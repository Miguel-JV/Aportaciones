<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\areas;


class casas extends Model
{
    protected $fillable = [
        'ID_CASA',
        'NOMBRE',
        'ESTATUS',
        'CORREO',

    ];
    protected $primaryKey = 'ID_CASA';
    public $timestamps = false;

    public function coordinador_casa(){
        return $this->belongsToMany('\App\coordinadores', 'coordinadores_casas', 'ID_CASA', 'ID_COORDINADOR');
    }

    public function encargados_casa(){
        return $this->belongsToMany('\App\encargados', 'encargados_casas', 'ID_CASA', 'ID_ENCARGADO');
    }

    public function supervisor_casa(){
        return $this->belongsToMany('\App\encargados', 'encargados_casas', 'ID_CASA', 'ID_ENCARGADO')->where('PUESTO', 'SUPERVISOR');
    }

    public function subgerente_casa(){
        return $this->belongsToMany('\App\encargados', 'encargados_casas', 'ID_CASA', 'ID_ENCARGADO')->where('PUESTO', 'SUBGERENTE');
    }

    public function gerente_casa(){
        return $this->belongsToMany('\App\encargados', 'encargados_casas', 'ID_CASA', 'ID_ENCARGADO')->where('PUESTO', 'GERENTE');
    }

    public function encargados_finanzas(){
        $id_finanzas = areas::where('NOMBRE','Finanzas Filiales')->first()->ID_AREA;
        return $this->belongsToMany('\App\encargados', 'encargados_casas', 'ID_CASA', 'ID_ENCARGADO')->where('ID_AREA', $id_finanzas);
    }

    public function director(){
        return $this->belongsTo('\App\directores', 'ID_CASA');
    }


}
