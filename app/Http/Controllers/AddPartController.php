<?php

namespace App\Http\Controllers;

use DB;
use Event;
use Illuminate\Http\Request;
use App\Http\Controllers\lib\dataController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\lib\LogController;

class AddPartController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->db = new dataController;
    }

    public function  show(){
        Event::fire(new \App\Events\UpdateKadet(2));
        return $this->render();
    }
    
    public function save(Request $request){
        $dir='/images/';
        $fileName='';
        
        $this->validateForm($request);
        
        if($request->isMethod('post')){

            if($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName= str_random(12).'.jpg';
                $file->move(public_path() . '/images',$fileName);
                $fileName = $dir.$fileName;
            }
         }
        try{
        $id=DB::table('part')->insertGetId([
            'accKadet'=>$request->input('kadet'),
            'accEvent'=>$request->input('event'),
            'accReach'=>$request->input('reach'),
            'accSubject'=>$request->input('subject'),
            'nClass'=>$request->input('class'),
            'dataEvent'=>$request->input('data'),
            'diploma'=>$fileName
        ]);
        foreach ($request->input('teacher') as $k => $v){
        DB::table('part_user')->insert([
            'user_id'=>$v,
            'part_id'=>$id
        ]);}
        
        LogController::addLog('добавил','в разделе "Добавление записей" <a href="/admin/parts/'. $id .'/edit"> ссылка</a> ');

         $status = 'Запись успешно добавлена';
        }
        catch (Exception $e){
         $status = 'произошла неизвестная ошибка при добавлении '. $e->getMessage();   
        }
       
        return $this->render($status);
        
    }

    public function render($status=''){
        $data['Events']= $this->db->getEventsData();
        $data['class']=$this->db->getClasses();
        $data['teachers']= $this->db->getTeachers();
        $data['kadets']= $this->db->getKadets();
        $data['reach']= $this->db->getReach();
        $data['subject']= $this->db->getSubject();
        return view('addPart',['data'=>$data,'status'=>$status]);
    }
    
    public  function validateForm(Request $request){
        
        $this->validate($request, [
            'kadet'  => 'bail|required',
            'data' => 'bail|required',
            'class' => 'bail|required',
            'teacher' => 'bail|required',
            'reach' => 'bail|required',
            'subject' => 'bail|required',
            'event' => 'bail|required',
        ]
        , $this->messages());
    }
    
    public function messages(){

        
       return  ['kadet.required'  => 'поле "кадет" обязательно для заполнения',
            'data.required' => 'поле "дата" обязательно для заполнения',
            'class.required' => 'поле "класс" обязательно для заполнения',
            'teacher.required' => 'поле "преподаватель" обязательно для заполнения',
            'reach.required' => 'поле "место" обязательно для заполнения',
            'event.required' => 'поле "мероприятие" обязательно для заполнения',
            'subject.required' => 'поле "предмет" обязательно для заполнения'];
    }
    
}
