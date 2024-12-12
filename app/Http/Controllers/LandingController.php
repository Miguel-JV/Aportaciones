<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function landingAldea(){
        return view('Landing.aldea-index');
    }

    public function landingGeneral(){
        return view('Landing.general-index');
    }


    public function cardAldea(){
        $mensaje = 'mensaje';
        return view('Landing.card-aldea', compact('mensaje'));
    }
}
