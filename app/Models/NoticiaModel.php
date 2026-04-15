<?php

namespace App\Models;

use CodeIgniter\Model;

class NoticiaModel extends Model
{
    protected $table = 'noticias';
    protected $primaryKey = 'id';

    protected $allowedFields = ['titulo', 'descripcion', 'estado', 'imagen', 'fecha_creacion', 'autor_id'];
}