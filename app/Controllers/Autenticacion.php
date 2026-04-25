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

    public function recuperarPassword()
{
    $model = new UsuarioModel();

    $email = $this->request->getPost('email');

    // 🔹 Validar que no esté vacío
    if (!$email) {
        return redirect()->back()->with('error', 'Ingresá un correo');
    }

    $user = $model->where('email', $email)->first();

    // 🔒 Seguridad: NO revelar si el correo existe o no
    if (!$user) {
        return redirect()->back()
            ->with('success', 'Si el correo existe, te enviamos un enlace');
    }

    // 🔐 Generar token
    $token = bin2hex(random_bytes(32));
    $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

    $model->update($user['id'], [
        'reset_token' => $token,
        'reset_expira' => $expira
    ]);

    $link = base_url("reset_password/$token");

    // 📧 Enviar email
    $emailService = \Config\Services::email();
    $emailService->setFrom('seylagiselrivero@gmail.com', 'Portal BTS'); 
    $emailService->setTo($email);
    $emailService->setSubject('Recuperar contraseña');

    $emailService->setMessage("
        <div style='font-family:sans-serif'>
            <h2 style='color:#7b2cbf'>Recuperar contraseña</h2>
            <p>Solicitaste restablecer tu contraseña.</p>
            <p>
                <a href='$link' 
                   style='background:#7b2cbf;color:white;padding:10px 15px;text-decoration:none;border-radius:5px;'>
                   Restablecer contraseña
                </a>
            </p>
            <p>Este enlace expira en 1 hora.</p>
        </div>
    ");

    if ($emailService->send()) {
        return redirect()->back()
            ->with('success', 'Te enviamos un correo con instrucciones');
    } else {
        // 🔴 Mostrar error real (solo para desarrollo)

           return redirect()->back()
           ->with('error', 'No se pudo enviar el correo');
            
    }
}
public function resetPassword()
{
    $model = new UsuarioModel();

    $rules = [
        'password' => 'required|min_length[6]',
        'confirmar' => 'required|matches[password]'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $token = $this->request->getPost('token');
    $password = $this->request->getPost('password');

    $user = $model->where('reset_token', $token)->first();

    if (!$user) {
        return redirect()->to('/')->with('error', 'Token inválido');
    }

    if (strtotime($user['reset_expira']) < time()) {
        return redirect()->to('/')->with('error', 'Token expirado');
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

   $model->update($user['id'], [
        'password' => $hash,
        'reset_token' => null,
        'reset_expira' => null
    ]);

    return redirect()->to('/')
    ->with('success', 'Contraseña actualizada')
    ->with('modal', 'login');
}
public function formReset($token)
{
    $model = new UsuarioModel();

    $user = $model->where('reset_token', $token)->first();

    if (!$user) {
        return redirect()->to('/')->with('error', 'Token inválido');
    }

    if (strtotime($user['reset_expira']) < time()) {
        return redirect()->to('/')->with('error', 'El enlace expiró');
    }

    return view('Noticias/reset_password', [
        'token' => $token
    ]);
}
public function formRecuperar()
{
    return view('Noticias/recuperar_password');
}
}