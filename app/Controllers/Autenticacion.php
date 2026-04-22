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
        ->with('errors', $this->validator->getErrors())
        ->with('modal', 'registro');
}

    $model = new UsuarioModel();

        // Obtener roles
        $rol_editor = $this->request->getPost('rol_editor') ? 1 : 0;
        $rol_validador = $this->request->getPost('rol_validador') ? 1 : 0;
        $rol_ambos = $this->request->getPost('rol_ambos');

        // Si selecciona "ambos"
        if ($rol_ambos) {
            $rol_editor = 1;
            $rol_validador = 1;
        }

        if ($rol_editor == 0 && $rol_validador == 0) {
        return redirect()->back()
            ->withInput()
            ->with('error_roles', 'Debe seleccionar al menos un rol')
            ->with('modal', 'registro');
}


        // Guardar usuario
        $id = $model->insert([
            'nombre' => $this->request->getPost('nombre'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),
            'rol_editor' => $rol_editor,
            'rol_validador' => $rol_validador
        ]);

        $usuario = $model->find($id);

        // 🔐 Seguridad: regenerar sesión
        session()->regenerate();

        // Login automático
        session()->set([
            'id' => $usuario['id'],
            'nombre' => $usuario['nombre'],
            'rol_editor' => $usuario['rol_editor'],
            'rol_validador' => $usuario['rol_validador'],
            'logueado' => true
        ]);

    return redirect()->to('/');
}
    

    public function validar()
    {
         $rules = [
        'email' => [
            'rules' => 'required|valid_email|is_not_unique[usuarios.email]',
            'errors' => [
                'required' => 'El email es obligatorio',
                'valid_email' => 'Ingresá un email válido',
                'is_not_unique' => 'El email no está registrado'
            ]
        ],
        'password' => [
        'rules' => 'required|min_length[6]',
        'errors' => [
            'required' => 'La contraseña es obligatoria',
            'min_length' => 'La contraseña debe tener al menos 6 caracteres'
        ]
    ],
    ];
    //  errores de validación (inputs vacíos, etc)
    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            //->with('errors', $this->validator->getErrors())
            ->with('validation', $this->validator) 
            ->with('modal', 'login');
    }

        $model = new UsuarioModel();

        $email = trim($this->request->getPost('email'));
        $password = trim($this->request->getPost('password'));

        if ($email === '' || $password === '') {
        return redirect()->back()
            ->withInput()
            ->with('validation', $this->validator)
            ->with('modal', 'login');
}

        $usuario = $model->where('email', $email)->first();
    
        //  email no existe
        if (!$usuario) {
            return redirect()->back()
               ->withInput()
               ->with('error_login', 'El email no está registrado')
               ->with('modal', 'login');
                
        }

        if (!$this->validator->getErrors() &&
           !password_verify($password, $usuario['password'])
        ) {
           return redirect()->back()
                ->withInput()
               ->with('error_login', 'Contraseña incorrecta')
                ->with('modal', 'login');
        }

        session()->regenerate();

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