<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Kadet;
use App\Klass;
use App\Http\Controllers\lib\LogController;

class ImportController extends Controller
{
    protected $fileName = 'file';
     public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function addFile(Request $request){
        $dir = 'temp/';
        
        if($request->isMethod('post')){

            if($request->hasFile('f')) {
                $file = $request->file('f');
                $file->move(public_path() . '/temp',$this->fileName);
                $this->fileName = $dir.$this->fileName;
                
                return true;
            }
         }
         return false;
    }
    
    public function import(Request $request){
        if($this->addFile($request) == true){
            $file = Excel::load($this->fileName)->toArray();
        }
        $array = $this->formatArray($file);

	
       try{
        if (is_array($array)){
            foreach($array as $k => $v){

               if(!is_numeric($v[0])){
                $kadet = new Kadet;
                 if ($v[0] !== NULL)
                     $kadet->KLastName = $v[0];
                 if ($v[1] !== NULL)
                      $kadet->KFirstName = $v[1];
                 if ($v[2] !== NULL)
                     $kadet->KSecondName = $v[2];
                 if ($v['klass'] !== NULL)
                     $kadet->accClass = $this->getClass($v['klass']);
                 if ($v['data_rozhdeniya'] !== NULL)
                     $kadet->birthdata = $this->formatData($v['data_rozhdeniya']);
                $kadet->studyKK = 1;

                $kadet->save();
               }
            }
        } else {
            return redirect('admin/kadets?import=false');
        }
        LogController::addLog('импорт','выполнил импорт ('. count($array).' строк)');
        return redirect('/admin/kadets?import=true');
      }catch(Exception $e){
	return redirect('admin/kadets?import=false');
}
    }
    
    protected  function formatData($data){
        $dat = '';
        if($data !== NULL){
            list($day, $month, $year) = sscanf($data, "%02d.%02d.%04d"); 
            $dat="$year.$month.$day";         
        }
        return $dat;
    }


    protected function getClass($class){
        $class = str_replace(" ","",$class);
        if ($class !== NULL){
            $res = Klass::where('nameClass','=',$class)->get();
            foreach ($res as $k){
                $cl = $k->account;
            }
        }
        return $cl;
    }
    
    protected function formatArray($array){
        $newArray = [];
        $foo=[];
        $err =0 ;
        if(is_array($array)){
            foreach($array as $k => $v){
                foreach($v as $k2 => $v2){  
                    if(is_string($k2)){
                        if ($k2 == 'familiya_imya_otchestvo'){
                            $foo = explode(' ', $v2);
                        }

                        if ($k2 == 'klass'){
                            $foo[$k2] = $v2;
                        }

                        if ($k2 == 'data_rozhdeniya'){
                            $foo[$k2] = $v2;
                        }
                    } else $err++;
                }
                if ($err < 2)
                    $newArray = $this->addInNewArray($foo,$newArray);
                else return false;
            }
        }
        
        
        if(count($newArray) == 0)
            return false;
        
        return $newArray;
    }
    
    protected function addInNewArray ($var, $array){
       
        $i = count($array) + 1;
        
        if (isset($var)) {
            if (is_array($var)) {
                    $array[$i] = $var; 
            }
        }
        return $array;
    }

}
