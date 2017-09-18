<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\lib\dataController;

class KadetController extends Controller
{
    protected $db;

    public function __construct() {
        $this->middleware('auth');
        $this->db = new dataController;
    }

    public function kadets()
    {
    $query= $this->db->getAllKadets() ->paginate(15);
    return $this->render($query);
    }
    


/**
 * 
 * @param Request $request
 * @return this render($quer)
 */
    public function  filter(Request $request){
        $query = $this->db->getAllKadets();
        $fbirthdate=$request->input('fbirthdate');
        $sbirthdate=$request->input('sbirthdate');
        $class=$request->input('class');
                
        
        if($fbirthdate !== NULL ){
            $sbirthdate=date("j.n.Y");
            $query->where('kadet.birthdata','>=',$fbirthdate)
                  ->where('kadet.birthdata','<=',$sbirthdate);
        } 
        if($sbirthdate !== NULL ){
            $fbirthdate=date("01.01.2000");
            $query->where('kadet.birthdata','>=',$fbirthdate)
                  ->where('kadet.birthdata','<=',$sbirthdate);
        } 
        if($fbirthdate && $sbirthdate !== NULL ){
            $query->where('kadet.birthdata','>=',$fbirthdate)
                  ->where('kadet.birthdata','<=',$sbirthdate);
        } 
        
        if($class !== NULL){
            $query->Where(function($qu){
                    $mas= request()->input('class');
                    foreach ($mas as $k =>$v)
                        $qu->orWhere('kadet.accClass', '=', $v);
                   
                });
        }        
        $quer=$query->paginate(15)->appends([
            'fbirthdate'=>$fbirthdate,
            'sbirthdate'=>$sbirthdate,
            'class'=>$class]);  
        return $this->render($quer);
    }
    
     public function render($query){
        if(count($query)==0)
        {$status=0;}
        else
        {$status=1;}
        $data['kadets']=$query;
        $data['classes']=$this->db->getClasses();
        return view('kadetView',['kadets'=>$data],['status'=>$status]);
    }      
}
    
