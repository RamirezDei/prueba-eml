<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombres',
        'apellidos',
        'correo',
        'telefono',
        'fecha_registro',
        'fecha_modificacion',
    ];
}