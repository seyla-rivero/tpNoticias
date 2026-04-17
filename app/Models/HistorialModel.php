<?php

namespace App\Models;

use CodeIgniter\Model;

class HistorialModel extends Model
{
    protected $table = 'historial_noticias';
    protected $allowedFields = [
        'noticia_id',
        'usuario_id',
        'estado_anterior',
        'estado_nuevo',
        'fecha'
    ];
}