<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\lib\dataController;
use App\part;

class TestController extends Controller
{

    protected $db;
    protected $event;
    protected $class;
    protected $teacher;
    protected $kadet;
    protected $sData;
    protected $fData;
    protected $reach;
    protected $queryString;

    public function __construct(Request $request) {
        $this->middleware('auth');
        $this->db = new dataController;
        
        $this->event=$request->input('event');
        $this->class=$request->input('class');
        $this->teacher=$request->input('teacher');
        $this->kadet=$request->input('kadet');
        $this->sData=$request->input('secondData');
        $this->fData=$request->input('firstData');
        $this->reach=$request->input('reach');
        $this->queryString=request()->server->get('HTTP_REFERER');
    }


    public function index(){
        $query= $this->db->getAllParts()->paginate(15);   
      
        return $this->render($query);
    }
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function  filter(Request $request){
        $query= $this->db->getAllParts();
                
        if($this->event !== NULL){
            $query->Where(function($qu){
               $mas= request()->input('event');
                    foreach ($mas as $k =>$v)
                        $qu->orWhere('event.nameEvent', '=', $v);
                });   
        } 
        
        if($this->class !== NULL){
               $query->Where(function($qu){
               $mas= request()->input('class');
                    foreach ($mas as $k =>$v)
                        $qu->orWhere('part.nClass', '=', $v);
                });  
        } 
        
        if($this->teacher !== NULL){
            $query->Where('part_user.user_id', '=', $this->teacher);  
        }
        
        if($this->kadet !== NULL){
            $query->Where('part.accKadet', '=', $this->kadet); 
        }
        
        if($this->fData && $this->sData !== NULL){
            $query->where('part.dataEvent','>=',$this->fData)
                  ->where('part.dataEvent','<=',$this->sData);
        } elseif ($this->fData !== NULL){
            $query->where('part.dataEvent','>=',$this->fData);
        } elseif ($this->sData !== NULL){
            $query->where('part.dataEvent','<=',$this->sData);
        }
        
        
        
        if($this->reach !== NULL){
            
                $query->Where(function($qu){
                    $mas= request()->input('reach');
                    foreach ($mas as $k =>$v)
                        $qu->orWhere('part.accReach', '=', $v);
                   
                });
                
            
        }
        $quer=$query->paginate(15)->appends([
            'event'=>$this->event,
            'kadet'=>$this->kadet,
            'teacher'=>$this->teacher,
            'class'=>$this->class,
            'secondData'=>$this->sData,
            'firstData'=>$this->fData,
            'reach'=>$this->reach]);  
        return $this->render($quer);
    }


    /**
     * 
     * @param type $query
     * @return type
     */
    public function render($query){
        if(count($query)==0)
        {$status=0;}
        else
        {$status=1;}
        $data['posts']=$query;
        $data['Events']= $this->db->getEventsData();
        $data['class']=$this->db->getClasses();
        $data['teachers']= $this->db->getTeachers();
        $data['kadets']= $this->db->getKadets();
        $data['reach']=$this->db->getReach();
        $this->event=request()->getQueryString();
        return view('posts',['posts'=>$data],['status'=>$status]);
    }
    
    public function updateImage(Request $request){
        $dir='/images/';
        $fileName='';
       
        
        if($request->isMethod('post')){

            if($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName= str_random(12).'.jpg';
                $file->move(public_path() . '/images',$fileName);
                $fileName = $dir.$fileName;
                $part = part::find($request->input('id'));
                $part->diploma = $fileName;
                $part->save();
            }
         }
         //dump($request);
         //dump($fileName);
         return back();
    }
    
    public function toExport(){
       $str = explode('?', $this->queryString);
        if( isset($str[1]) )
            return redirect('excel?'.$str[1]);
        else 
            return redirect('excel');
    }
        
   
        
}
