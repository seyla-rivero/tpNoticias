<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfiguracionModel extends Model{
    protected $table = 'configuracion';
    protected $allowedFields = ['dias_expiracion', 'max_imagen'];
}