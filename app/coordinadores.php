<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class coordinadores extends Model
{
    protected $fillable = [
        'ID_COORDINADOR',
        'NOMBRE',
        'TELEFONO',
        'CORREO',
        'VALIDACION'
    ];
    protected $primaryKey = 'ID_COORDINADOR';
    public $timestamps = false;

}
