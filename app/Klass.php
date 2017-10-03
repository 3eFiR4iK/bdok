<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Klass extends Model
{
    protected $table = 'class';
    protected $primaryKey = 'account';
    
    public function employee(){
        return $this->belongsTo(\App\User::class,'accEmployee','id');
    }
}
