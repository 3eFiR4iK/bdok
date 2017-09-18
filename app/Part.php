<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class part extends Model
{
    protected $table='part';
    
    protected  $primaryKey='id_part';
    
    protected $fillable=[
        'accKadet',
        'accEvent',
        'accReach',
        'accEmployee',
        'accSubject',
        'nClass',
        'diploma'
    ];


    public function event(){
        return $this->belongsTo(\App\event::class, 'accEvent','account');
    }
    
    public function kadet(){
        return $this->belongsTo(\App\Kadet::class,'accKadet','account');
    }
    
    public function  reach(){
        return $this->belongsTo(\App\Reach::class,'accReach','account');
    }
    
//    public function users (){
//        return $this->belongsTo(\App\User::class,'')
//    }
    
    public function subject(){
        return $this->belongsTo(\App\Subject::class,'accSubject','account');
    }
    
    public function users(){
        return $this->belongsToMany(\App\User::class,'part_user','part_id','user_id');
    }
    
    public function level(){
        return $this->belongsTo(\App\Level::class,'accLevel','id');
    }
}
