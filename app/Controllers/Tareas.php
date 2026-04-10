<?php

namespace App\Controllers;

use App\Models\TareaModel;

class Tareas extends BaseController
{
    public function index()
    {
        $model = new TareaModel();
        $data['tareas'] = $model->findAll();

        return view('tareas/index', $data);
        
    }

    public function crear()
    {
        return view('tareas/crear');
    }

    public function guardar()
    {
        $model = new TareaModel();

        $model->save([
            'titulo' => $this->request->getPost('titulo')
        ]);

         return redirect()->to(base_url('tareas'));

    }
}