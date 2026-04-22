<?php

namespace App\Controllers;

use App\Models\NoticiaModel;
use App\Models\HistorialModel;
use App\Models\UsuarioModel;
use App\Models\ConfiguracionModel;
class Noticias extends BaseController
{

   
   public function index()
{
    $model = new NoticiaModel();

    // 🔥 actualizar expiradas
    $this->verificarExpiracion();

    $data['noticias'] = $model
        ->where('estado', 'Publicada')
        ->orderBy('fecha_publicacion', 'DESC')
        ->orderBy('id', 'DESC')
        ->findAll();

    return view('Noticias/index', $data);
}
public function misNoticias()
{
    if (!session()->get('logueado')) {
        return redirect()->to('/');
    }

    $model = new NoticiaModel();

    $estado = $this->request->getGet('estado');

    $usuario_id = session()->get('id');

    $model = $model->where('autor_id', $usuario_id);


    if (!empty($estado)) {
        $model = $model->where('estado', $estado);
    }

    $data['noticias'] = $model->findAll();
    $data['estado'] = $estado;
    
    return view('Noticias/misNoticias', $data);
}
private function verificarExpiracion()
{
    $model = new NoticiaModel();
    $configModel = new ConfiguracionModel();
    $historialModel = new HistorialModel();

    $dias = $configModel->first()['dias_expiracion'];

    $noticias = $model->where('estado', 'Publicada')->findAll();

    foreach ($noticias as $n) {

        if ($n['fecha_publicacion']) {

            if ((time() - strtotime($n['fecha_publicacion'])) > ($dias * 86400)) {
                  
                 // 🔥 guardar historial
                $historialModel->save([
                    'noticia_id' => $n['id'],
                    'usuario_id' => 0, // sistema
                    'estado_anterior' => 'Publicada',
                    'estado_nuevo' => 'Expirada'
                ]);

                $model->update($n['id'], [
                    'estado' => 'Expirada'
                ]);
            }
        }
    }
}

    public function crear()
    {   
        if (session('rol_editor') != 1) {
        return redirect()->to('/noticias');
    }
        return view('Noticias/crear');
    }

    public function guardar($id = null)
{
    if (!$this->validate('noticia')) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $model = new NoticiaModel();

    $accion = $this->request->getPost('accion');
    $titulo = trim($this->request->getPost('titulo'));

    // 🔹 Validación duplicado
    $existePublicada = $model->where('titulo', $titulo)
                             ->where('estado', 'Publicada')
                             ->first();

    if ($existePublicada && in_array($accion, ['validar'])) {
        return redirect()->back()->withInput()->with('errors', [
            'titulo' => 'Ya existe una noticia publicada con este título.'
        ]);
    }

    // 🔹 Estado
    switch ($accion) {
        case 'validar':
            $estado = 'Lista para Validación';
            break;

        case 'anular':
            $estado = 'Anulada';
            break;

        default:
            $estado = 'Borrador';
            break;
    }

    // 🔹 Buscar noticia actual (si es edición)
    $noticiaActual = null;
    if ($id) {
        $noticiaActual = $model->find($id);
    }

    // 🔹 Imagen
    $eliminarImagen = $this->request->getPost('eliminar_imagen');
    $imagen = $this->request->getFile('imagen');
    $nombreImagen = $noticiaActual['imagen'] ?? null;

    // 🔴 Si el usuario quiere eliminar la imagen
    if ($eliminarImagen) {

        if (!empty($noticiaActual['imagen']) && file_exists('uploads/' . $noticiaActual['imagen'])) {
            unlink('uploads/' . $noticiaActual['imagen']);
        }

        $nombreImagen = null;
    }
    // 🟢 Si sube una nueva imagen
    elseif ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {

        // borrar la anterior
        if (!empty($noticiaActual['imagen']) && file_exists('uploads/' . $noticiaActual['imagen'])) {
            unlink('uploads/' . $noticiaActual['imagen']);
        }

        $nombreImagen = $imagen->getRandomName();
        $imagen->move('uploads/', $nombreImagen);
    }

    // 🔹 Datos
    $data = [
        'titulo' => $titulo,
        'descripcion' => $this->request->getPost('descripcion'),
        'estado' => $estado,
        'imagen' => $nombreImagen,
        'autor_id' => session()->get('id')
    ];

    // 🔹 Si hay ID → actualizar
    if ($id) {
        $data['id'] = $id;
    }

    $model->save($data);
    $historialModel = new HistorialModel();

    // Obtener estado anterior
    $estadoAnterior = $id ? $noticiaActual['estado'] : 'Creada';

    // ID de la noticia
    $noticiaId = $id ?? $model->getInsertID();

    // Registrar historial SOLO si cambió el estado
    if ($estadoAnterior !== $estado) {
        $historialModel->insert([
            'noticia_id' => $noticiaId,
            'estado_anterior' => $estadoAnterior,
            'estado_nuevo' => $estado,
            'usuario_id' => session()->get('id')
        ]);
    }

    return redirect()->to('/noticias');
}
    public function cambiarEstado($id)
{
    $accion = $this->request->getPost('accion');

    $model = new NoticiaModel();
    $historialModel = new HistorialModel();

    $noticia = $model->find($id);

    $rolEditor = session()->get('rol_editor');
    $rolValidador = session()->get('rol_validador');

    if (!$noticia) {
        return redirect()->back();
    }
    // 🔐 Evitar que valide su propia noticia
    if (
        in_array($accion, ['publicar', 'correccion']) &&
        $noticia['autor_id'] == session()->get('id')
    ) {
        return redirect()->back()
            ->with('error', 'No podés validar tu propia noticia.');
    }

    // 🚫 No modificar si está cerrada
    if (in_array($noticia['estado'], ['Publicada', 'Expirada'])) {
        return redirect()->back()->with('error', 'No se puede modificar esta noticia');
    }
    
    $estadoAnterior = $noticia['estado'];
    $data = [];
    
    $redirect = '/noticias';
    
    switch ($accion) {

        // 🟡 SOLO EDITOR
        case 'validar':
            if (!$rolEditor) {
                return redirect()->back()->with('error', 'No tenés permisos');
            }

            if (!in_array($noticia['estado'], ['Borrador', 'Para Corrección'])) {
                return redirect()->back()->with('error', 'Estado inválido');
            }

            $data['estado'] = 'Lista para Validación';
            break;
        case 'anular':
            if (!$rolEditor) {
                return redirect()->back()->with('error', 'No tenés permisos');
            }

            if ($noticia['estado'] != 'Borrador') {
                return redirect()->back()->with('error', 'Solo se puede anular desde Borrador');
            }

            $data['estado'] = 'Anulada';
            break;

        // 🔵 SOLO VALIDADOR
        case 'publicar':
            if (!$rolValidador) {
            return redirect()->back();
        }

        if ($noticia['estado'] != 'Lista para Validación') {
            return redirect()->back()->with('error', 'No se puede publicar en este estado');
        }

        $data['estado'] = 'Publicada';
        $data['fecha_publicacion'] = date('Y-m-d H:i:s');
        $redirect = '/noticias/pendientes';
        break;
        //$model->update($id, $data);

        //return redirect()->to(base_url('noticias/pendientes'));
        case 'correccion':
            if (!$rolValidador) {
                return redirect()->back();
            }

            if ($noticia['estado'] != 'Lista para Validación') {
                return redirect()->back();
            }

            $data['estado'] = 'Para Corrección';
            $redirect = '/noticias/pendientes';
            break;
            //$model->update($id, $data);

            //return redirect()->to(base_url('noticias/pendientes'));

        default:
           
            return redirect()->to(base_url('noticias'));
    }

    // ✅ ACTUALIZAR NOTICIA
        $model->update($id, $data);

        $historialModel->save([
            'noticia_id' => $id,
            'usuario_id' => session()->get('id'),
            'estado_anterior' => $estadoAnterior,
            'estado_nuevo' => $data['estado']
        ]);

        return redirect()->to($redirect);
        }

        public function pendientes()
    {
        $model = new NoticiaModel();

        $data['noticias'] = $model
            ->where('estado', 'Lista para Validación')
            ->where('autor_id !=', session()->get('id'))
            ->findAll();

        return view('noticias/listaValidador', $data);
    }

        public function detalle($id)
    {
        $model = new NoticiaModel();

        $noticia = $model->find($id);

        if (!$noticia) {
            return redirect()->to('/noticias');
        }

        return view('Noticias/detalle', ['noticia' => $noticia]);
    }
    public function editar($id)
    {
        $model = new NoticiaModel();
        $noticia = $model->find($id);

        if (in_array($noticia['estado'], ['Publicada', 'Expirada'])) {
            return redirect()->to('/noticias')
                ->with('error', 'No se puede editar esta noticia');
        }

        return view('Noticias/editar', ['noticia' => $noticia]);
    }

    public function historial($id)
{
    // Verificar sesión y roles
    if (
        !session()->get('logueado') || 
        (!session()->get('rol_editor') && !session()->get('rol_validador'))
    ) {
        return redirect()->to('/login');
    }

    $historialModel = new HistorialModel();
    $usuarioModel = new UsuarioModel();

    $historial = $historialModel
        ->where('noticia_id', $id)
        ->orderBy('fecha', 'ASC')
        ->findAll();

    // Agregar nombre del usuario
    foreach ($historial as &$h) {
        $user = $usuarioModel->find($h['usuario_id']);
        $h['nombre'] = $user['nombre'] ?? 'Desconocido';
    }

    return view('Noticias/historial', ['historial' => $historial]);
}

    public function configuracion()
    {
        $model = new ConfiguracionModel();
        $config = $model->first();

        return view('noticias/configuracion', [
            'config' => $config
        ]);
    }

    public function guardarConfiguracion()
    {
        $model = new ConfiguracionModel();

         $data = [
        'dias_expiracion' => $this->request->getPost('dias_expiracion'),
        'max_imagen' => $this->request->getPost('max_imagen')
         ];

        // ⚠️ IMPORTANTE: actualizar registro existente
        $model->update(1, $data);

        return redirect()->back()->with('success', 'Configuración actualizada');
    }
}
