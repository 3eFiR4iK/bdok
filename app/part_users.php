<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class part_users extends Model
{
    protected  $table='part_users';
    
    public function part(){
        return $this->belongsToMany(\App\part::class,'part_users');
    }
}
