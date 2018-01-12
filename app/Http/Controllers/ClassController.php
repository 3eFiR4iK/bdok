<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\lib\dataController;

class ClassController extends Controller
{
    protected $db;

    public function __construct() {
        $this->middleware('auth');
        $this->db = new dataController;
    }

    public function classes()
    {
    $query= $this->db->getAllClasses() ->paginate(15);
    //return view('class',['classes'=>$query]);
    return $this->render($query);
    }
    
    public function  filter(Request $request){
        $query = $this->db->getAllClasses();
        $class=$request->input('class');
        $rota=$request->input('rota');
        $course=$request->input('course');
        $employee=$request->input('employee');
        
        if($class !== NULL){
            $query->Where(function($qu){
               $mas= request()->input('class');
                    foreach ($mas as $k =>$v)
                        $qu->orWhere('class.account', '=', $v);
                });   
        } 
        if($rota !== NULL){
            $query->Where(function($qu){
               $mas= request()->input('rota');
                    foreach ($mas as $k =>$v)
                        $qu->orWhere('class.accRota', '=', $v);
                });    
        } 
        if($course !== NULL){
            $query->Where(function($qu){
               $mas= request()->input('course');
                    foreach ($mas as $k =>$v)
                        $qu->orWhere('rota.nameCourse', '=', $v);
                });   
        } 
        if($employee !== NULL){
            $query->where('class.accEmployee','=',$employee); 
        } 
         
           
        $quer=$query->paginate(15)->appends([
            'class'=>$class,
            'rota'=>$rota,
            'course'=>$course,
            'employee'=>$employee]);  
        return $this->render($quer);
    }
    
    public function render($query){
        if(count($query)==0)
        {$status=0;}
        else
        {$status=1;}
        $data['classes']=$query;
        $data['class']= $this->db->getClasses();
        $data['rotas']=$this->db->getRotas();
        $data['courses']=$this->db->getCourses();
        $data['employees']=$this->db->getTeachers();
        return view('class',['classes'=>$data],['status'=>$status]);
    }  
    
    
    
    
    
    
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

