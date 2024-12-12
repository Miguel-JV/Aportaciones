<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tickets extends Model
{

    protected $fillable = [
        'ID_TICKET',
        'ID_CASA',
        'ID_AFECCION',
        'ID_ENTORNO',
        'ID_TIPO_DANO',

        'FOLIO',
        'FECHA_INICIO',
        'CASA',
        'DIRECTOR',
        'AFECCION',
        'AREA_RESPONSABLE',
        'SUPERVISOR',
        'SUBGERENTE',
        'GERENTE',

        'PRIORIDAD',
        'NIVEL',

        'REINCIDENCIA',
        'ENTORNO',
        'SITIO',
        'OBJETO',
        'ESPACIO',
        'ELEMENTO',
        'DAÑO',
        'DRIVE',
        'DETALLE',

        'FOTO_OBLIGATORIA',
        'FOTO_2',
        'FOTO_3',

        'ARCHIVO_COTIZACION',
        'ARCHIVO_AUTORIZACION',

        'COTIZACION',
        'FECHA_COMPROMISO',

        'ESTATUS_CASA',
        'ESTATUS_COTIZACION',
        'ESTATUS_AUTORIZACION',
        'ESTATUS_ACTUAL',
        'ESTATUS_PAGO',

        'EVIDENCIA_PAGO',


        'FECHA_FIN',
        'AREA_ATENCION',
        'PERSONA_ATENCION',
        'OBSERVACIONES',


        'EVIDENCIA_TERMINO',
        'EVIDENCIA_TERMINO_2',
        'EVIDENCIA_TERMINO_3',
    ];
    protected $primaryKey = 'ID_TICKET';

    public function casa(){
        return $this->belongsTo('\App\casas',  'ID_CASA');
    }
    public function afeccion(){
        return $this->belongsTo('\App\afecciones',  'ID_AFECCION');
    }

    public function modificaciones(){
        return $this->hasMany('\App\modificaciones',  'ID_TICKET', 'ID_TICKET');
    }

}
