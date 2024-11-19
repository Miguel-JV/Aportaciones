<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function landing(){
        $mensaje = 'mensaje';
        return view('Landing.diseño_2', compact('mensaje'));
    }
    public function videosLanding(){
        return view('Landing.diseño_4');
    }
}
