<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class directores extends Model
{

    protected $fillable = [
        'ID_DIRECTOR',
        'ID_CASA',
        'ID_USUARIO',

        'NOMBRE',
        'CORREO',
    ];


    protected $primaryKey = 'ID_DIRECTOR';
    public $timestamps = false;

    public function casa(){
        return $this->belongsTo('\App\casas', 'ID_CASA');
    }

    public function usuario(){
        return $this->morphOne('\App\user', 'userable');
    }

}
