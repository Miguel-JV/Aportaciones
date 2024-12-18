<?php

namespace App;
use App\User;

use Illuminate\Database\Eloquent\Model;


class coordinadores extends Model
{

    protected $fillable = [
        'ID_COORDINADOR',

        'NOMBRE',
        'TELEGRAM',
        'CORREO',
        'VALIDACION',
    ];


    protected $primaryKey = 'ID_COORDINADOR';
    public $timestamps = false;

    public function usuario(){
        return $this->morphOne(User::class, 'userable');
    }

    public function casa(){
        return $this->belongsToMany('\App\casas', 'coordinadores_casas',  'ID_COORDINADOR', 'ID_CASA');
    }

}
