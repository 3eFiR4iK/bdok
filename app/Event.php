<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Level;
class event extends Model
{
    protected $table='event';
    
    protected $fillable=[
        'nameEvent','accLevel'
    ]; 
    
    protected  $primaryKey='account';


    public function level(){
        return $this->belongsTo(Level::class,'accLevel','id');
    }
    
    
    
}
