<?php

namespace App\Controllers;

use App\Models\NoticiaModel;

class Noticias extends BaseController
{
    public function index()
    {
        $model = new NoticiaModel();
        $data['noticias'] = $model->orderBy('id', 'DESC')->findAll();

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

        $estado = ($accion == 'validar') ? 'En validación' : 'Borrador';

        // 🔹 Manejo de imagen
        $imagen = $this->request->getFile('imagen');
        $nombreImagen = null;

        if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
            $nombreImagen = $imagen->getRandomName();
            $imagen->move('uploads/', $nombreImagen);
        }

        // 🔹 Guardar en BD
        $model->save([
            'titulo' => $this->request->getPost('titulo'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado' => $estado,
            'imagen' => $nombreImagen
        ]);

        return redirect()->to('/noticias');
    }
}
