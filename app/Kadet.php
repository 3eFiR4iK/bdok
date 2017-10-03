<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\KadetClass;
class Kadet extends Model
{
    protected  $table='kadet';
    
    protected  $primaryKey='account';
    
    protected  $fillable=[
        'KLastName',
        'KFirstName',
        'KSecondName',
        'birthdata',
        'accClass',
        'studyKK'
    ];
    
    
    public function KadetClass (){
        return $this->belongsTo(KadetClass::class,'accClass','account');
    }
    
    public function getFullNameAttribute()
    {
        return $this->KLastName.' '.$this->KFirstName.' '.$this->KSecondName;
    }
    
    public static function boot() {
        parent::boot();
        static::updating(function ($model){
            if($model->studyKK == 0)
                if($model->dateOut !== NULL){
                    $date = date("Y");
                    $model->date_out = $date-1 .'-'. $date;
                }
        });
    }
}
