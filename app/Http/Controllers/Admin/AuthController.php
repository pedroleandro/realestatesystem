<?php

namespace LaraDev\Http\Controllers\Admin;

use Illuminate\Http\Request;
use LaraDev\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.index');
    }

    public function home()
    {
        return view('admin.dashboard');
    }

    public function login(Request $request)
    {
        if(in_array('', $request->only('email', 'password'))){
            $json['message'] = 'Whooooops!!! Por favor, informe todos os dados corretamente para efetuar o login.';
            return response()->json($json);
        }
    }
}
