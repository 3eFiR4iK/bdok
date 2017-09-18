<?php

namespace App\Http\Controllers\lib;


use App\Http\Controllers\Controller;
use DB;

class dataController extends Controller
{
    
     public function getAllParts(){
        return DB::table('part')->select('part.accKadet',
                'part.accEvent',
                'part.accLevel',
                'part.dataEvent',
                'part.accReach',
                'part.accSubject',
                'part.nClass',
                'part.diploma',
                'part.id_part',
                'reach.*','kadet.created_at as creat',
                'kadet.KLastName',
                'kadet.KFirstName',
                'kadet.KSecondName',

                'event.*','part_user.*','subject.*', 
                DB::raw("group_concat(users.LastName,' ',users.FirstName,' ',users.SecondName) AS full_name"))
                ->join('kadet','part.accKadet','=','kadet.account')
                ->join('event','part.accEvent','=','event.account')
                ->join('reach','part.accReach','=','reach.account')
                ->join('part_user','part.id_part','=','part_user.part_id')
                ->join('users','part_user.user_id','=','users.id')
                ->join('subject','part.accSubject','=','subject.account')
                ->groupBy('part_id')
                ->orderBy('part.id_part','desc');
                
    }
     public function getAllKadets()
    {
       return DB::table('kadet')
              ->join('class','class.account','=','kadet.accClass')
              ->join('rota','class.accRota','=','rota.account')
              ->join('users','class.accEmployee','=','users.id')
              ->select('kadet.account','KLastName','KFirstName','KSecondName',
                      'birthdata','studyKK','nameclass','quantity','nameRota',
                      'nameCourse','LastName','FirstName','SecondName');
   }
   public function getAllClasses()
   {
       return DB::table('class')
               ->join('rota','rota.account','=','class.accRota')
               ->join('users','users.id','=','class.accEmployee')
               ->select('class.account','nameClass','quantity','nameRota',
                       'nameCourse','LastName','FirstName','SecondName');
   }
   

    public function  getEventsData(){
        return DB::table('event')->select('account','nameEvent')->get();
    }
    
    public function  getClasses(){
        return DB::table('class')->orderBy('nameClass','asc')->get();
    }
    
    public function  getTeachers(){
        return DB::table('users')->select('id','LastName','FirstName','SecondName')->orderBy('LastName','asc')->get();
    }
    
     public function  getRotas(){
        return DB::table('rota')->select('account','nameRota')->orderBy('nameRota','asc')->get();
    }
    
    public function  getCourses(){
        return DB::table('rota')->select('nameCourse')->orderBy('nameCourse','asc')->get();
    }
    
    public function  getKadets(){
        return DB::table('kadet')->select('account','KLastName','KFirstName','KSecondName')->orderBy('KLastName','asc')->get();
    }
    
    public function  getReach(){
        return DB::table('reach')->get();
    }
    public function  getSubject(){
        return DB::table('subject')->get();
    }
    
   
    
}
