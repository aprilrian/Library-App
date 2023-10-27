<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiController extends Controller
{
    function index()
    {
        return view('login.login');
    }

    function login(Request $request)
    {

        $request->validate(
            [
                'email'=>'required',
                'password'=>'required'
            ],
            [
                'email.required'=>'Email harus diisi!',
                'password.required'=>'Password harus diisi!'
            ],
        );

        $infologin = [
            'email'=>$request->email,
            'password'=>$request->password,
        ];
        if(Auth::attempt($infologin)){
            if(Auth::user()->role == 'petugas'){
                return redirect('/dashboard');
            }
        }

        return redirect('')->withErrors('Email atau password salah')->withInput();
    }

    function logout()
    {
        Auth::logout();
        return redirect('');
    }
}
