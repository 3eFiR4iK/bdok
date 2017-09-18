<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TesttController extends Controller
{
    public static function show($data){
        dump($data);
        return view('test');
    }
}
