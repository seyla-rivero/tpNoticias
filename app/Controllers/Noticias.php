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

        $builder = $model;

        // FILTRAR POR USUARIO LOGUEADO
        $builder = $builder->where('autor_id', session()->get('id'));

        // BUSCAR POR TITULO
        if (!empty($buscar)) {
            $builder = $builder->like('titulo', $buscar);
        }

        // FILTRAR POR ESTADO
        if (!empty($estado)) {
            $builder = $builder->where('estado', $estado);
        }

        $data['noticias'] = $builder->findAll();

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

    // 🔥 VALIDACIÓN DE DUPLICADO (ACÁ VA)
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
