<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Autenticacion extends BaseController
{
    
    public function guardar()
{
   
    $rules = [
    'nombre' => [
        'rules' => 'required|min_length[3]',
        'errors' => [
            'required' => 'El nombre es obligatorio',
            'min_length' => 'El nombre debe tener al menos 3 caracteres'
        ]
    ],
    'email' => [
        'rules' => 'required|valid_email|is_unique[usuarios.email]',
        'errors' => [
            'required' => 'El email es obligatorio',
            'valid_email' => 'Ingresá un email válido',
            'is_unique' => 'Este correo ya está registrado'
        ]
    ],
    'password' => [
        'rules' => 'required|min_length[6]',
        'errors' => [
            'required' => 'La contraseña es obligatoria',
            'min_length' => 'La contraseña debe tener al menos 6 caracteres'
        ]
    ],
    'confirmar' => [
        'rules' => 'required|matches[password]',
        'errors' => [
            'required' => 'Debés confirmar la contraseña',
            'matches' => 'Las contraseñas no coinciden'
        ]
    ]
];

    if (!$this->validate($rules)) {
    return redirect()->back()
        ->withInput()
        ->with('errors', $this->validator->getErrors());
}

    $model = new UsuarioModel();

    $model->save([
        'nombre' => $this->request->getPost('nombre'),
        'email' => $this->request->getPost('email'),
        'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        'rol_editor' => in_array('editor', $this->request->getPost('rol') ?? []) ? 1 : 0,
        'rol_validador' => in_array('validador', $this->request->getPost('rol') ?? []) ? 1 : 0
    ]);

    // login automático
    $usuario = $model->where('email', $this->request->getPost('email'))->first();

    session()->set([
        'id' => $usuario['id'],
        'nombre' => $usuario['nombre'],
        'logueado' => true
    ]);

    return redirect()->to('/');
}
    

    public function validar()
    {
         $rules = [
        'email' => [
            'rules' => 'required|valid_email',
            'errors' => [
                'required' => 'El email es obligatorio',
                'valid_email' => 'Ingresá un email válido'
            ]
        ],
        'password' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'La contraseña es obligatoria'
            ]
        ]
    ];
    // ❌ errores de validación (inputs vacíos, etc)
    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }

        $model = new UsuarioModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $usuario = $model->where('email', $email)->first();

        // ❌ email no existe
        if (!$usuario) {
            return redirect()->back()
                ->withInput()
                ->with('error_login', 'El email no está registrado');
        }

        // ❌ contraseña incorrecta
        if (!password_verify($password, $usuario['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('error_login', 'Contraseña incorrecta');
        }

        // ✅ login correcto
        session()->set([
            'id' => $usuario['id'],
            'nombre' => $usuario['nombre'],
            'rol_editor' => $usuario['rol_editor'],
            'rol_validador' => $usuario['rol_validador'],
            'logueado' => true
        ]);

            return redirect()->to('/noticias');
        }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}