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

    // 👇 SOLO si está logueado filtrás por usuario
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

    public function guardar()
{
    if (!$this->validate('noticia')) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $model = new NoticiaModel();

    // 🔹 Detectar qué botón se presionó
    $accion = $this->request->getPost('accion');
    $titulo = trim($this->request->getPost('titulo'));

    //  VALIDACIÓN DE DUPLICADO (ACÁ VA)
    $existe = $model->where('titulo', $titulo)
                    ->where('estado', 'Publicada')
                    ->first();

    if ($existe && $accion == 'validar') {
        return redirect()->back()->withInput()->with('errors', [
            'titulo' => 'Ya existe una noticia publicada con este título.'
        ]);
    }

    $estado = ($accion == 'validar') ? 'Lista para Validación' : 'Borrador';

    // 🔹 Manejo de imagen
    $imagen = $this->request->getFile('imagen');
    $nombreImagen = null;

    if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
        $nombreImagen = $imagen->getRandomName();
        $imagen->move('uploads/', $nombreImagen);
    }

    // 🔹 Guardar en BD
    $model->save([
        'titulo' => $titulo,
        'descripcion' => $this->request->getPost('descripcion'),
        'estado' => $estado,
        'imagen' => $nombreImagen,
        'autor_id' => 1
    ]);

    return redirect()->to('/noticias');
}
}
