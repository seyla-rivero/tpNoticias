<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
    public array $noticia = [
    'titulo' => [
        'label' => 'Título',
        'rules' => 'required|min_length[10]|max_length[100]'
    ],
    'descripcion' => [
        'label' => 'Descripción',
        'rules' => 'required|min_length[50]'
    ],
    'imagen' => [
        'label' => 'Imagen',
        'rules' => 'if_exist|max_size[imagen,2048]|is_image[imagen]|mime_in[imagen,image/jpg,image/jpeg,image/png]'
    ],
    ];

    public array $registro = [
    'nombre' => 'required|min_length[3]',
    'email'  => 'required|valid_email|is_unique[usuarios.email]',
    'password' => 'required|min_length[6]',
    'confirmar' => 'required|matches[password]'
];
}
