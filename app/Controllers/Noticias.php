<?php

namespace App\Controllers;

use App\Models\NoticiaModel;

class Noticias extends BaseController
{
   public function index()
{
    $model = new NoticiaModel();

    $buscar = $this->request->getGet('buscar');
    $estado = $this->request->getGet('estado');

    //  SOLO si está logueado filtrás por usuario
    if (session()->get('logueado')) {
        $usuario_id = session()->get('id');
        $model = $model->where('autor_id', $usuario_id);
    }

    if (!empty($buscar)) {
        $model = $model->like('titulo', $buscar);
    }

    if (!empty($estado)) {
        $model = $model->where('estado', $estado);
    }

    $data['noticias'] = $model->findAll();

    return view('Noticias/index', $data);
}

    public function crear()
    {
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
    $imagen = $this->request->getFile('imagen');
    $nombreImagen = $noticiaActual['imagen'] ?? null;

    if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
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

    return redirect()->to('/noticias');
}
    public function cambiarEstado($id)
{
    $accion = $this->request->getPost('accion');

    $model = new NoticiaModel();
    $noticia = $model->find($id);

    $rolEditor = session()->get('rol_editor');
    $rolValidador = session()->get('rol_validador');

    if (!$noticia) {
        return redirect()->back();
    }

    // 🚫 No modificar si está cerrada
    if (in_array($noticia['estado'], ['Publicada', 'Expirada'])) {
        return redirect()->back()->with('error', 'No se puede modificar esta noticia');
    }

    $rolEditor = session()->get('rol_editor');
    $rolValidador = session()->get('rol_validador');

    $data = [];

    switch ($accion) {

        // 🟡 SOLO EDITOR
        case 'validar':
            //if (!$rolEditor) return redirect()->back();
            //$data['estado'] = 'Lista para Validación';
            //break;
            if (!$rolEditor) {
                return redirect()->back()->with('error', 'No tenés permisos');
            }

            if ($noticia['estado'] != 'Borrador') {
                return redirect()->back()->with('error', 'Estado inválido');
            }

            $data['estado'] = 'Lista para Validación';
            break;
        case 'anular':
             //f (!$rolEditor) return redirect()->back();
            //$data['estado'] = 'Anulada';
            //break;
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
           // if (!$rolValidador) return redirect()->back();
            //if ($noticia['estado'] != 'Lista para Validación') {
                //return redirect()->back();
            //}
            //$data['estado'] = 'Publicada';
            //$data['fecha_publicacion'] = date('Y-m-d H:i:s');
            //break;
            if (!$rolValidador) {
                return redirect()->back();
            }

            if ($noticia['estado'] != 'Lista para Validación') {
                return redirect()->back()->with('error', 'No se puede publicar en este estado');
            }

            $data['estado'] = 'Publicada';
            $data['fecha_publicacion'] = date('Y-m-d H:i:s');
            break;
        case 'corregir':
         
            //if (!$rolValidador) return redirect()->back();
            //$data['estado'] = 'Para Corrección';
           // break;
            if (!$rolValidador) {
                return redirect()->back();
            }

            if ($noticia['estado'] != 'Lista para Validación') {
                return redirect()->back();
            }

            $data['estado'] = 'Para Corrección';
            break;

        default:
            //return redirect()->back();
            return redirect()->to(base_url('noticias'));
    }

    $model->update($id, $data);

    return redirect()->back();
}

        public function pendientes()
    {
        $model = new NoticiaModel();

        $data['noticias'] = $model
            ->where('estado', 'Lista para Validación')
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
}
