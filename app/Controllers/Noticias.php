<?php

namespace App\Controllers;

use App\Models\NoticiaModel;

class Noticias extends BaseController
{
    public function index()
    {
        $model = new NoticiaModel();

        $data['noticias'] = $model->findAll();

        return view('Noticias/index', $data);
    }
     public function crear()
    {
        return view('Noticias/crear');
    }
    public function guardar()
    {
        $model = new NoticiaModel();

        $model->save([
            'titulo' => $this->request->getPost('titulo'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado' => 'Borrador'
        ]);

        return redirect()->to('/noticias');
    }
}
