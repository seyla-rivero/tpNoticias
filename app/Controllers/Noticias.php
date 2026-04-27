<?php

namespace App\Controllers;

use App\Models\NoticiaModel;
use App\Models\HistorialModel;
use App\Models\UsuarioModel;
use App\Models\ConfiguracionModel;

// Controlador encargado de la gestión de noticias, maneja la creación, edición, validación, publicación y expiración, controla roles y flujo de estados, Registra historial de cambios para auditoría
class Noticias extends BaseController{

   //Muestra el listado público de noticias
   public function index(){
        $model = new NoticiaModel();

        //Verifica si hay noticias que tienen que pasar a expiradas
        $this->verificarExpiracion();
        //Solo muestra noticias en estado publicadas y ordena por fecha más reciente

        $data['noticias'] = $model
            ->select('noticias.*, usuarios.nombre as autor_nombre')
            ->join('usuarios', 'usuarios.id = noticias.autor_id')
            ->where('estado', 'Publicada')
            ->orderBy('fecha_publicacion', 'DESC')
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('Noticias/index', $data);
    }
    //Muestra las noticias del usuario logueado
    public function misNoticias(){
        //Verifica que el usuario tenga sesión iniciada
        if (!session()->get('logueado')) {
            return redirect()->to('/');
        }

        $model = new NoticiaModel();

        $estado = $this->request->getGet('estado');

        $usuario_id = session()->get('id');
        //Filtra las noticias por autor
        $model = $model->where('autor_id', $usuario_id);


        if (!empty($estado)) {
            $model = $model->where('estado', $estado);
        }

        $data['noticias'] = $model->findAll();
        $data['estado'] = $estado;
        //Retorna las noticias del usuario
        return view('Noticias/misNoticias', $data);
    }

    //Verifica automáticamente si hay noticias que deben expirar
    private function verificarExpiracion(){

        $model = new NoticiaModel();

        $configModel = new ConfiguracionModel();
        $historialModel = new HistorialModel();
        //Obtiene la cantidad de días configurados para expiración
        $dias = $configModel->first()['dias_expiracion'];
        
        $noticias = $model->where('estado', 'Publicada')->findAll();
        //Recorre todas las noticias publicadas
        foreach ($noticias as $n) {

            if ($n['fecha_publicacion']) {

                if ((time() - strtotime($n['fecha_publicacion'])) > ($dias * 86400)) {
                    
                    //Si una noticia supera el tiempo, pasa a estado expirada y se registra en el historial
                    $historialModel->save([
                        'noticia_id' => $n['id'],
                        'usuario_id' => 0, 
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
    //Muestra el formulario para crear una noticia
    public function crear(){  
        //Solo permite acceso a usuarios con rol Editor
        if (session('rol_editor') != 1) {
            return redirect()->to('/noticias');
        }
        //Si no tiene permiso, redirige al listado de noticias
        return view('Noticias/crear');
    }

    //Crea o actualiza una noticia
    public function guardar($id = null){
        
        //Valida los datos del formulario
        if (!$this->validate('noticia')) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new NoticiaModel();

        $accion = $this->request->getPost('accion');
        $titulo = trim($this->request->getPost('titulo'));

        //Evita duplicados de títulos en noticias publicadas
        $existePublicada = $model->where('titulo', $titulo)
                                ->where('estado', 'Publicada')
                                ->first();

        if ($existePublicada && in_array($accion, ['validar'])) {
            return redirect()->back()->withInput()->with('errors', [
                'titulo' => 'Ya existe una noticia publicada con este título.'
            ]);
        }

        //Define el estado según la acción
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

        $noticiaActual = null;
        if ($id) {
            $noticiaActual = $model->find($id);
        }

        //Maneja la carga, reemplazo o eliminación de imagen
        $eliminarImagen = $this->request->getPost('quitar_imagen');
        $imagen = $this->request->getFile('imagen');
        $nombreImagen = $noticiaActual['imagen'] ?? null;

        
        if ($eliminarImagen) {

            if (!empty($noticiaActual['imagen']) && file_exists('uploads/' . $noticiaActual['imagen'])) {
                unlink('uploads/' . $noticiaActual['imagen']);
            }

            $nombreImagen = null;
        } elseif ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {

            if (!empty($noticiaActual['imagen']) && file_exists('uploads/' . $noticiaActual['imagen'])) {
                unlink('uploads/' . $noticiaActual['imagen']);
            }

            $nombreImagen = $imagen->getRandomName();
            $imagen->move('uploads/', $nombreImagen);
        }

        $data = [
            'titulo' => $titulo,
            'descripcion' => $this->request->getPost('descripcion'),
            'estado' => $estado,
            'imagen' => $nombreImagen
        ];

        //Nueva noticia, asigna el autor
        if (!$id) {
            $data['autor_id'] = session()->get('id');
        }
        //Guarda en base de datos
        if ($id) {
        $model->update($id, $data);
        } else {
            $model->insert($data);
        }

        $historialModel = new HistorialModel();

    
        $estadoAnterior = $id ? $noticiaActual['estado'] : 'Creada';

    
        $noticiaId = $id ?? $model->getInsertID();

        //Registra en el historial si hubo cambios
        if ($estadoAnterior !== $estado) {
            $historialModel->insert([
                'noticia_id' => $noticiaId,
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => $estado,
                'usuario_id' => session()->get('id')
            ]);
        }
        //Redirige con mensaje de éxito
        $accion = $this->request->getPost('accion');

        if ($id) {

            if ($accion === 'validar') {
                return redirect()->to('/noticias')
                    ->with('success', 'Noticia enviada a validación correctamente');
            }

            return redirect()->to('/noticias')
                ->with('success', 'Noticia actualizada con éxito');

        } else {

            return redirect()->to('/noticias')
                ->with('success', 'Noticia creada con éxito');
        }
    }
    //Cambia el estado de una noticia
    public function cambiarEstado($id){

        $accion = $this->request->getPost('accion');

        $model = new NoticiaModel();
        $historialModel = new HistorialModel();

        $noticia = $model->find($id);
        //Controla permisos según rol
        $rolEditor = session()->get('rol_editor');
        $rolValidador = session()->get('rol_validador');

        if (!$noticia) {
            return redirect()->back();
        }
        //Evita que el usuario valide su propia noticia
        if (in_array($accion, ['publicar', 'correccion']) &&
            $noticia['autor_id'] == session()->get('id')) {
                return redirect()->back()
                ->with('error', 'No podés validar tu propia noticia.');
            }

        //No permite modificar noticias expiradas o publicadas
        if (in_array($noticia['estado'], ['Publicada', 'Expirada'])) {
            return redirect()->back()->with('error', 'No se puede modificar esta noticia');
        }
    
        $estadoAnterior = $noticia['estado'];
        $data = [];
        
        $redirect = '/noticias';
        //Define acciones
        switch ($accion) {

            //Solo editor
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

            //Solo validador
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
            default:
                return redirect()->to(base_url('noticias'));
        }

        //Actualiza el estado 
        $model->update($id, $data);
        //Registra el cambio en el historial
        $historialModel->save([
            'noticia_id' => $id,
            'usuario_id' => session()->get('id'),
            'estado_anterior' => $estadoAnterior,
            'estado_nuevo' => $data['estado']
        ]);
        
        //Mensaje según acción
        $mensaje = '';

        switch ($accion) {

            case 'validar':
                $mensaje = 'Noticia enviada a validación correctamente';
                break;

            case 'publicar':
                $mensaje = 'Noticia publicada con éxito';
                break;

            case 'correccion':
                $mensaje = 'Noticia enviada para corrección';
                break;

            case 'anular':
                $mensaje = 'Noticia anulada correctamente';
                break;
        }

        return redirect()->to($redirect)
            ->with('success', $mensaje);
    }
    //Muestras noticias en estado validación
    public function pendientes(){

        $model = new NoticiaModel();
        //Solo incluye noticias en estado Lista para validación
        //Excluye las noticias creadas por el usuario actual
        $data['noticias'] = $model
            ->where('estado', 'Lista para Validación')
            ->where('autor_id !=', session()->get('id'))
            ->findAll();

        return view('noticias/listaValidador', $data);
    }
    //Muestra el detalle de una noticia
    public function detalle($id){
        $model = new NoticiaModel();
        // Busca la noticia  y nombre del autor
        $noticia = $model
            ->select('noticias.*, usuarios.nombre as autor_nombre')
            ->join('usuarios', 'usuarios.id = noticias.autor_id')
            ->where('noticias.id', $id)
            ->first();
            
        //Si no existe, redirige al listado
        if (!$noticia) {
            return redirect()->to('/noticias');
        }
        //Si existe, carga la vista de sus datos
        return view('Noticias/detalle', ['noticia' => $noticia]);
    }
    //Muestra el formulario de edición de una noticia
    public function editar($id){
        $model = new NoticiaModel();
        $noticia = $model->find($id);
        //No permite editar noticias en estado publicadas o expiradas
        if (in_array($noticia['estado'], ['Publicada', 'Expirada'])) {
            return redirect()->to('/noticias')
                ->with('error', 'No se puede editar esta noticia');
        }
        //Si está permitido, carga la vista con los datos
        return view('Noticias/editar', ['noticia' => $noticia]);
    }
    //Muestra el historial de cambios de una noticia 
    public function historial($id){
        //Verifica que el usuario este logueado y tenga rol válido
        if (!session()->get('logueado') || (!session()->get('rol_editor') && !session()->get('rol_validador'))) {
            return redirect()->to('/login');
        }

        $historialModel = new HistorialModel();
        $usuarioModel = new UsuarioModel();
        //Obtiene todos los cambios de estado ordenados por fecha
        $historial = $historialModel
            ->where('noticia_id', $id)
            ->orderBy('fecha', 'ASC')
            ->findAll();

        // Agregar nombre del usuario que realizó la acción
        foreach ($historial as &$h) {
            $user = $usuarioModel->find($h['usuario_id']);
            $h['nombre'] = $user['nombre'] ?? 'Desconocido';
        }
        //Retorna el historial
        return view('Noticias/historial', ['historial' => $historial]);
    }
    //Muestra la configuración del sistema
    public function configuracion(){
        $model = new ConfiguracionModel();
        
        $config = $model->first();

        return view('noticias/configuracion', [
            'config' => $config
        ]);
    }
    //Guarda la configuración del sistema
    public function guardarConfiguracion(){
        $model = new ConfiguracionModel();
       
        $data = [
        'dias_expiracion' => $this->request->getPost('dias_expiracion'),
        'max_imagen' => $this->request->getPost('max_imagen')
         ];

        
        $model->update(1, $data);

        return redirect()->back()->with('success', 'Configuración actualizada');
    }
}
