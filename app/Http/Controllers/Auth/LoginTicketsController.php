<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;



class LoginTicketsController extends Controller
{
    use AuthenticatesUsers;


    public function mostrarLogin()
    {
        return view('auth.loginTickets');
    }

    public function login(Request $request)
    {
        // Validar contenido de los inputs
        $this->validate($request, [
            'folio' => 'required',
            'password' => 'required',
        ]);

        // Redirecccion en caso de usuario director
        if(Auth::guard('web')->attempt([
            'folio'       => $request->input('folio'),
            'password'      => $request->input('password'),
        ], $request->remember) ){
            return redirect()->intended(route('consultar.ticket'));
        }


        // Redirecccion en caso de credenciales erroneas
        return redirect()->back()->withInput($request->only('folio'));
        // return $request->all();
    }
}
