<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
//Controlador encargado de la autenticación de usuarios
//Gestiona registro, login, logout y recuperación de contraseña
class Autenticacion extends BaseController{

    //Registro de usuario
    public function guardar(){
    
    //Registrar un nuevo usuario, validar los datos
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
    //Asigna el rol
    $rol = $this->request->getPost('rol');

    if (!$rol) {
        return redirect()->back()
            ->withInput()
            ->with('error_roles', 'Debe seleccionar un rol')
            ->with('modal', 'registro');
    }
    $rol_editor = 0;
    $rol_validador = 0;

    
    if ($rol == 'editor') {
        $rol_editor = 1;
        $rol_validador = 0;
    } elseif ($rol == 'validador') {
        $rol_editor = 0;
        $rol_validador = 1;
    } elseif ($rol == 'ambos') {
        $rol_editor = 1;
        $rol_validador = 1;
    }

    $nombre = $this->request->getPost('nombre');
    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');
    //Guarda el usuario en la base de datos
    $id = $model->insert([
        'nombre' => $nombre,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'rol_editor' => $rol_editor,
        'rol_validador' => $rol_validador
    ]);

    if (!$id) {
        return redirect()->back()
            ->withInput()
            ->with('error_general', 'Error al registrar usuario')
            ->with('modal', 'registro');
        }

    $usuario = $model->find($id);

       
    session()->regenerate();

    //Inicia sesion automaticamente si todo sale bien
    session()->set([
        'id' => $usuario['id'],
        'nombre' => $usuario['nombre'],
        'rol_editor' => $usuario['rol_editor'],
        'rol_validador' => $usuario['rol_validador'],
        'logueado' => true
    ]);
    //Redirige al inicio
    return redirect()->to('/');
}
    
    //Login
    public function validar(){
        //Valida el inicio de sesion de un usuario
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
    
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
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
    
        //Verifica que el email este en la base de datos
        if (!$usuario) {
            return redirect()->back()
               ->withInput()
               ->with('error_login', 'El email no está registrado')
               ->with('modal', 'login');
                
        }
        //Comprueba que la contraseña coincida
        if (!$this->validator->getErrors() &&
           !password_verify($password, $usuario['password'])
        ) {
           return redirect()->back()
                ->withInput()
               ->with('error_login', 'Contraseña incorrecta')
                ->with('modal', 'login');
        }

        session()->regenerate();

        //Si los datos son correctos, se crea la sesión y guarda los datos en la sesión
        session()->set([
            'id' => $usuario['id'],
            'nombre' => $usuario['nombre'],
            'rol_editor' => $usuario['rol_editor'],
            'rol_validador' => $usuario['rol_validador'],
            'logueado' => true
        ]);
        //Redirige a la sección noticias
        return redirect()->to('/noticias');
    }
    //Cerrar sesión
    public function logout(){
        //Cierra la sesión del usuario y elimina los datos de sesión
        session()->destroy();
        //Redirige al inicio
        return redirect()->to('/');
    }
    //Solicitud de recuperación
    public function recuperarPassword(){
        //Solicita el restablecimiento de contraseña   
        $model = new UsuarioModel();

        $email = $this->request->getPost('email');

        //Verifica si el email fue ingresado
        if (!$email) {
            return redirect()->back()->with('error', 'Ingresá un correo');
        }

        $user = $model->where('email', $email)->first();

        
        if (!$user) {
            return redirect()->back()
                ->with('success', 'Si el correo existe, te enviamos un enlace');
        }

        //Genera un token único y una fecha de expiración
        $token = bin2hex(random_bytes(32));
        $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $model->update($user['id'], [
            'reset_token' => $token,
            'reset_expira' => $expira
        ]);
        //Guarda el token en la base de datos
        $link = base_url("reset_password/$token");

        //Envía un email para restablecer la contraseña
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
        //Muestra mensaje de exito o error
        if ($emailService->send()) {
            return redirect()->back()
                ->with('recuperar', true)
                ->with('success', 'Te enviamos un correo con instrucciones');
        } else {
            return redirect()->back()
            ->with('error', 'No se pudo enviar el correo');
        }
    }
    //Cambiar contraseña
    public function resetPassword(){
        //Permite restablecer la contraseña usando el token
        $model = new UsuarioModel();
        //Valida la nueva contraseña y su confirmación
        $rules = [
        'password' => [
            'rules' => 'required|min_length[6]',
            'errors' => [
                'required'   => 'La contraseña es obligatoria',
                'min_length' => 'La contraseña debe tener al menos 6 caracteres'
            ]
        ],
        'confirmar' => [
            'rules' => 'required|matches[password]',
            'errors' => [
                'required' => 'Confirmá la contraseña',
                'matches'  => 'Las contraseñas no coinciden'
            ]
        ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');

        $user = $model->where('reset_token', $token)->first();
        //Verifica que el token sea válido
        if (!$user) {
            return redirect()->to('/')->with('error', 'Token inválido');
        }
        //Verifica que el token no haya expirado
        if (strtotime($user['reset_expira']) < time()) {
            return redirect()->to('/')->with('error', 'Token expirado');
        }
        //Encripta la nueva contraseña 
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        //Actualiza la nueva contraseña en la base de datos y elimina el token usado
        $model->update($user['id'], [
            'password' => $hash,
            'reset_token' => null,
            'reset_expira' => null
        ]);
        //Redirige al login con mensaje de éxito
        return redirect()->to('/')
            ->with('success', 'Contraseña actualizada')
            ->with('modal', 'login');
    }

     //Formulario recuperar contraseña
    public function formRecuperar(){
        //Solicita la recuperación de la contraseña
        return view('Noticias/recuperar_password');
    }

    //Formulario de nueva contraseña
    public function formReset($token){
        //Muestra el formulario para ingresar la nueva contraseña
        $model = new UsuarioModel();

        $user = $model->where('reset_token', $token)->first();
        //Verifica que el token exista
        if (!$user) {
            return redirect()->to('/')->with('error', 'Token inválido');
        }
        //Verifica que el token no haya expirado
        if (strtotime($user['reset_expira']) < time()) {
            return redirect()->to('/')->with('error', 'El enlace expiró');
        }
        //Si es válido, carga la vista del formulario
        return view('Noticias/reset_password', [
            'token' => $token
        ]);
    }
}