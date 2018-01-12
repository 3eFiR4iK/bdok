<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function  login (Request $request){

            if (Auth::attempt(['name' => $request->input('name'), 'password' => $request->input('password'), 'is_active' => 1])) {
                // Аутентификация успешна
                lib\LogController::addLog('Вход');
                  return redirect('/');
            }else
                 return redirect ('/login');
            
    }
    
    public function  logout (){
        Auth::logout();
        return redirect('/login');
    }
    
    public function show(){
        if (!Auth::check())
            return view('auth.login');
        else 
            return redirect ('/');
    }
}
