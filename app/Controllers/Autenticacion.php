<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Autenticacion extends BaseController
{
    
    public function guardar()
    {
        $model = new UsuarioModel();

        $password = $this->request->getPost('password');
        $confirmar = $this->request->getPost('confirmar');

        if ($password != $confirmar) {
            return redirect()->back()->with('error', 'Las contraseñas no coinciden');
        }

        $model->save([
            'nombre' => $this->request->getPost('nombre'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'rol_editor' => $this->request->getPost('rol_editor') ? 1 : 0,
            'rol_validador' => $this->request->getPost('rol_validador') ? 1 : 0
        ]);

        return redirect()->to('/login');
    }
    

    public function validar()
    {
        $model = new UsuarioModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $usuario = $model->where('email', $email)->first();

        if ($usuario && password_verify($password, $usuario['password'])) {

            session()->set([
                'id' => $usuario['id'],
                'nombre' => $usuario['nombre'],
                'rol_editor' => $usuario['rol_editor'],
                'rol_validador' => $usuario['rol_validador'],
                'logueado' => true
            ]);

            return redirect()->to('/noticias');
        }

        return redirect()->back()->with('error', 'Datos incorrectos');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}