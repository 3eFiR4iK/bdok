<?php

namespace App;

use App\event;
use Illuminate\Database\Eloquent\Model;

class level extends Model
{
    protected $table='level';
    
    public function event(){
        return $this->belongsTo(event::class);
    }
}
