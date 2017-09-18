<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KadetClass;
use App\Kadet;

class UpclassController extends Controller
{
        public function __construct()
    {
        $this->middleware('admin');
    }
    public function UpClass(){
        $class='';
        $id = NULL;
        $kadets = Kadet::with('KadetClass')->get();
        $foo='';
        foreach ($kadets as $kadet){

                $class = $kadet->KadetClass->nameClass;
                $class = $this->explode($class);
                $id = $kadet->account;
                if($kadet->studyKK !== 0){
                    if ($class[2] !== '1'){
                        $foo = Kadet::find($id);
                        if(count($class) == 4)
                            $foo->accClass = $this->getClass($class[1]+1 .$class[2]);
                        else
                            $foo->accClass = $this->getClass($class[1].$class[2]+ 1 .$class[3]);
                        $foo->save();
                        //$kadet->accClass = $this->getClass(substr($class,2)+1 .substr($class,-1));
                    }else{
                        $foo = Kadet::find($id);
                        $date = date("Y");
                        $foo->studyKK = 0;
                        $foo->date_out = $date-1 .'-'. $date;
                        $foo->save();
                    }
                }
                
            }
            return redirect('/admin/kadets?up=true');
    }
    
    protected function getClass($class){
        $id = NULL;
        if ($class !== NULL){
            $res = KadetClass::where('nameClass','=',$class)->get();
            foreach ($res as $cl){
                $id = $cl->account;
            }
        }
        return $id;
    }
    
    protected function explode($string){
        $matches='';
             $matches = preg_split('//u',$string);
        return $matches;
        
    }
}


