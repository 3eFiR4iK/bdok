<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'log';
    
    public function users(){
        return $this->belongsTo(\App\User::class,'user_id','id');
    }
}
