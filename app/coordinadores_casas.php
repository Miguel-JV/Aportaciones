<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class coordinadores_casas extends Model
{
    protected $fillable = [
        'ID_COORDINADORES_CASAS',
        'ID_SUPERVISOR',
        'ID_CASA'
    ];
    protected $primaryKey = 'ID_COORDINADORES_CASAS';
    public $timestamps = false;

}
