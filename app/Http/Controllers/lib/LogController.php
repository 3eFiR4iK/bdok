<?php

namespace App\Http\Controllers\lib;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Log;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public static function addLog($action,$section=NULL){
        Log::insert([
            'user_id'=> Auth::user()->id,
            'date'=>date("Y-m-d H:i:s"),
            'action'=>$action,
            'section'=>$section
        ]);
    }
}
