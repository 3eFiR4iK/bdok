<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
//use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel;
use Auth;
use App\part;
use App\Klass;
use App\Kadet;
use App\Http\Controllers\lib\LogController;

class ExcelController extends Controller
{
    protected $event;
    protected $class;
    protected $teacher;  
    protected $kadet;
    protected $sData;
    protected $fData;
    protected $reach;
    
    public function __construct(Request $request) {
        $this->middleware('auth');
        $this->event = $request->input('event');
        $this->class = $request->input('class');
        $this->teacher = $request->input('teacher');
        $this->kadet = $request->input('kadet');
        $this->sData = $request->input('secondData');
        $this->fData = $request->input('firstData');
        $this->reach = $request->input('reach');
    }
    
    protected function getUserFullName($post){
      $user = '';
        foreach ($post->users as $u) {
            $user = $u->LastName . ' ' . $u->FirstName . ' ' . $u->SecondName . ', ' . $user;
        }
        return $user;
    }
    
    protected function getKadetFullName($post){
        return $post->kadet->KLastName . ' ' . $post->kadet->KFirstName . ' ' . $post->kadet->KSecondName;
    }
    
    protected function getClassDate($date){
        
        foreach ($date as $k => $v){
            if ($k == 'date'){
                $foo = explode('-', $v);
            }
        }
        return substr($foo[0],2);
    }
    
    protected function formatArray($array, $key) {
        $i = 0;
        $j = 0;
        $ar=[];
        foreach ($array as $post) {
            foreach ($key as $k => $v) {
                $foo = explode('->', $v);

                if (count($foo) == 2 && $foo[1] !== 'created_at') {
                    $ar[$j][$i] = $post->$foo[0]->$foo[1];
                }else if(count($foo) == 2 && $foo[1] == 'created_at'){
                    $ar[$j][$i] = '(-'.$this->getClassDate($post->$foo[0]->$foo[1]).'г.)';
                } 
                
                else
                    $ar[$j][$i] = $post->$v;

                if ($v == 'users') {
                    $ar[$j][$i] = $this->getUserFullName($post);
                }
                if ($v == 'kadet') {
                    $ar[$j][$i] = $this->getKadetFullName($post);
                }
                

                $i++;
            }
            $i=0;
            $j++;
        }
       
       return $ar;
    }
    
    public function getData(){
        
        $query = part::with('users','event','kadet.KadetClass','reach','subject');
        
        $event = $this->event;
        $class = $this->class;
        $teacher = $this->teacher;
        $kadet = $this->kadet;
        $sData = $this->sData;
        $fData = $this->fData;
        $reach = $this->reach;
        
        
        if ($event !== NULL){
            $query->whereHas('event', function($q) use($event){
                $q->where(function($qer) use ($event){
                    foreach ($event as $k =>$v)
                      $qer->orWhere('nameEvent', '=', $v);  
                });        
            });
        }
        
        if ($class !== NULL){
            $query->where(function($q) use($class){
                $q->where(function($qer) use ($class){
                    foreach ($class as $k =>$v)
                      $qer->orWhere('nClass', '=', $v);  
                });        
            });
        }
        
        if ($fData && $sData !== NULL){
            $query->where('part.dataEvent','>=',$fData)
                  ->where('part.dataEvent','<=',$sData);
        } elseif ($fData !== NULL){
            $query->where('part.dataEvent','>=',$fData);
        } elseif ($sData !== NULL){
            $query->where('part.dataEvent','<=',$sData);
        }
        
        if($teacher !== NULL){
            $query->whereHas('users', function($q) use($teacher){
               $q->where('user_id', '=', $teacher)->orderBy('users.LastName');  
                });        
        }
        
        if($reach !== NULL){
            $query->whereHas('reach', function($q) use($reach){
               foreach ($reach as $k =>$v)
                  $q->orWhere('account', '=', $v);
            });
        }
        
        if($kadet !== NULL){
            $query->whereHas('kadet', function($q) use($kadet){
                $q->where('account', '=', $kadet);  
                });  
        }
        
        
        
       
        return $query->orderBy('dataEvent','desc')->get();
    }
    
    public function getDate($sDate, $fDate) {

        if ($sDate !== NUll) {
            foreach (part::where('dataEvent', '<=', $sDate)->orderBy('dataEvent', 'asc')->take(1)->get() as $foo) {
                $date[1] = $foo->dataEvent;
            }
            $date[2] = $sDate;
        } elseif ($fDate !== NULL) {
            foreach (part::where('dataEvent', '>=', $fDate)->orderBy('dataEvent', 'desc')->take(1)->get() as $foo) {
                $date[2] = $foo->dataEvent;
            }
            $date[1] = $fDate;
        } elseif ($sDate == NULL && $fDate == NULL) {

            foreach (part::orderBy('dataEvent', 'desc')->take(1)->get() as $foo) {
                $date[2] = $foo->dataEvent;
            }
            foreach (part::orderBy('dataEvent', 'asc')->take(1)->get() as $foo) {
                $date[1] = $foo->dataEvent;
            }
        } else {
            $date[2] = $sDate;
            $date[1] = $fDate;
        }

        return $date;
    }

    protected function doubleSort($array){
        $i=0;
        $j=0;
        $k=0;
        $tab = $this->getNameFilter();        
        $newArray= array();
        $classes = $this->formatArray(Klass::orderBy('orderClass')->get(), ['nameClass']);
        foreach ($classes as $k => $v){
            foreach ($v as $k2 => $class){
                
                foreach ($array as $k3 => $v2){
                    foreach ($v2 as $k4 => $v3){
                        if($v3 == $class){
                            $newArray[$i][$j] = $v2;
                            $j++;  
                        }
                    } 
                } $i++;$j=0;
                
            }

        }

        $newArray = $this->array_sort($newArray, 0);
        return $newArray;
    } 
    
    protected function sort ($array){
        $new =[];
        $tab = $this->getNameFilter();
        foreach ($array as $k => $v){

           foreach ($v as $k2 => $v2){
               if($k2 == $tab[1])
                $new[$k] = $v2; 
           }
        }
        
        asort($new);
        
        return $new;
    }
    
    protected function beforeSort($sortArray,$array){
        $xui =[];
        foreach ($sortArray as $k => $v2){         
                $xui[$k] = $array[$k];
        }
        return $xui;
    }
    
    
    protected function array_sort($array, $on, $order=SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();
        $ten  = array();
        $eleven = array();
        $i=0;
        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {                   
                        $sortable_array[$k2] = $v2;
                    }
                    $sortable_array = $this->sort($sortable_array);  
                    $sortable_array = $this->beforeSort($sortable_array, $array[$k]);
                    foreach ($sortable_array as $k3 => $v3){
                        $new_array[$i] = $sortable_array[$k3];
                        $i++;
                    }
                    $sortable_array = [];
                } 
            }

        }
        return $new_array;
    }
    
    protected function  getNameFilter(){
        $event = $this->event;
        $class = $this->class;
        $teacher = $this->teacher;
        $kadet = $this->kadet;
        $sData = $this->sData;
        $fData = $this->fData;
        $reach = $this->reach;
        
        if ($kadet !== NULL){
            $name[0] = 'по кадету';
            $name[1] = 0;
        } elseif ($teacher  !== NULL && $kadet == NULL){
            $name[0] = 'по преподавателю';
            $name[1] = 4;
        } elseif ($event !== NULL && $teacher == NULL){
            $name[0] = 'по мероприятию';
            $name[1] = 2;
        } elseif ($class !==NULL && $event == NULL){
            $name[0] = 'по классам';
            $name[1] = 0;
        } else {
            $name[0] = '';
            $name[1] = 0;
        }
        
        return $name ;
    }
    
    protected function  splitClass($array){
        $newArray = [];
        $i=0;
        if(is_array($array)){
            
            foreach ($array as $k => $v){
                $v[6]=$v[6].$v[7];
                unset($v[7]);
              $newArray[$i++]=$v;
              
            }   
        }
        return $newArray;
    }

    public function export(Request $request){
        
       $data = $this->getData($request);
       
       $d = $this->formatArray($data, [
            'kadet'
            ,'reach->nameReach'
            ,'event->nameEvent'
            ,'dataEvent'
            ,'users'
            ,'subject->nameSubject'
            ,'nClass'
            ,'kadet->created_at'
            ]);
       
       $date = $this->getDate($this->sData, $this->fData);
       $d = $this->doubleSort($d);
       $d = $this->splitClass($d);
       $name = $this->getNameFilter();
        $ex = Excel::create('отчет',function($excel) use($d,$date,$name){
           $excel->setTitle('this title');
           $excel->setCreator(Auth::user()->name);
           $excel->setCompany('SPBKK');
           $excel->setDescription('this description');
           
            $excel->sheet('Sheetname', function($sheet) use($d,$date,$name){
            
                $sheet->cells('A:G',function($cells){
                    $cells->setFontSize(13);
                    $cells->setFontFamily('Times New Roman');
                
                });
                
                $sheet->setAutoSize(true);
                $sheet->setWidth([
                    'A'=>33,
                    'B'=>11,
                    'C'=>37,
                    'D'=>13,
                    'E'=>30,
                    'F'=>18,
                    'G'=>12
                ]);
                $sheet->setWrapText(['A','C','E','F']);

                $sheet->cells('A:G',function ($cells){
                     $cells->setValignment('center');
                });
                
                $sheet->mergeCells('A1:G1');
                $sheet->mergeCells('A2:G2');
                $sheet->mergeCells('A3:G3');
                

                $sheet->cell('A1',function ($cell){
                    $cell->setValue('ФГКОУ "Санкт-Петербургский кадетский военный корпус МО РФ"');
                    $cell->setAlignment('center'); 
                    $cell->setBackground('D9D9D9');
                    $cell->setFont(['bold'=>true]);
                });
                $sheet->cell('A2',function ($cell) use($name){
                    $cell->setValue('ОТЧЕТ '.$name[0]);
                    $cell->setAlignment('center');
                    $cell->setFont(['bold'=>true]);
                    $cell->setBackground('#D9D9D9');
                });
                $sheet->cell('A3',function ($cell) use($date){
                    $cell->setValue('за период с '.$date[1].' по '.$date[2]);
                    $cell->setAlignment('center'); 
                    $cell->setBackground('D9D9D9');
                });
                $sheet->cell('A6',function ($cell){
                    $cell->setValue('ФИО Кадета');
                    $cell->setAlignment('center'); 
                    $cell->setBackground('#BFBFBF');
                    $cell->setFont(['bold'=>true]);
                });
                $sheet->cell('B6',function ($cell){
                    $cell->setValue('Место');
                    $cell->setAlignment('center'); 
                    $cell->setBackground('#BFBFBF');
                    $cell->setFont(['bold'=>true]);
                });
                $sheet->cell('C6',function ($cell){
                    $cell->setValue('Мероприятие');
                    $cell->setAlignment('center'); 
                    $cell->setBackground('#BFBFBF');
                    $cell->setFont(['bold'=>true]);
                });
                $sheet->cell('D6',function ($cell){
                    $cell->setValue('Дата');
                    $cell->setAlignment('center'); 
                    $cell->setBackground('#BFBFBF');
                    $cell->setFont(['bold'=>true]);
                });
                $sheet->cell('E6',function ($cell){
                    $cell->setValue('ФИО преподавателя (-лей)');
                    $cell->setAlignment('center'); 
                    $cell->setBackground('#BFBFBF');
                    $cell->setFont(['bold'=>true]);
                });
                $sheet->cell('F6',function ($cell){
                    $cell->setValue('Предмет');
                    $cell->setAlignment('center'); 
                    $cell->setBackground('#BFBFBF');
                    $cell->setFont(['bold'=>true]);
                });
                $sheet->cell('G6',function ($cell){
                    $cell->setValue('Класс');
                    $cell->setAlignment('center'); 
                    $cell->setBackground('#BFBFBF');
                    $cell->setFont(['bold'=>true]);
                });
                

//                $sheet->cell('Q2',function($cell){
//                    $date = date('j F Y');
//                    $date = explode(' ', $date);
//                    switch ($date[1]){
//                        case 'April':       $date[1]  ='Апреля';break;
//                        case 'January' :    $date[1]  ='Января';break;
//                        case 'February' :   $date[1]  ='Февраля';break;
//                        case 'March' :      $date[1]  ='Марта';break;
//                        case 'May' :        $date[1]  ='Мая';break;
//                        case 'June' :       $date[1]  ='Июня';break;
//                        case 'July' :       $date[1]  ='Июля';break;
//                        case 'August' :     $date[1]  ='Августа';break;
//                        case 'September' :  $date[1]  ='Сентября';break;
//                        case 'October' :    $date[1]  ='Октября';break;
//                        case 'November' :   $date[1]  ='Ноября';break;
//                        case 'December' :   $date[1]  ='Декабря';break;
//                   }
//                    $date = $date[0].' '.$date[1].' '.$date[2];
//
//                    $cell->setValue($date);
//                    $cell->setAlignment('right'); 
//                });
                
                $sheet->fromArray($d, null, 'A7', true, false);                
             });
        })->export('xls');
	LogController::addLog('Мероприятия','Экспорт отчета по мероприятиям');
        
        return $ex;
    }
    
    public function exportKadets(Request $request){
        $res = Kadet::where('accClass','=',$request->input('class'))
                ->where('studyKK','=','1')->orderBy('KLastName')->get();
        $class = Klass::with('employee')->find($request->input('class'));
        $colection = collect();
        foreach ($res as $kadet){
            $colection->push(["fio"=>$kadet->getFullNameAttribute()]);
        }
        
        $ex = Excel::create('Кадеты из '.$class->nameClass,function ($excel) use($class,$colection){
           $excel->setTitle('this title');
           $excel->setCreator(Auth::user()->name);
           $excel->setCompany('SPBKK');
           $excel->setDescription('this description');
           
            $excel->sheet('Sheetname', function($sheet) use($class,$colection){
                $sheet->cells('A:G',function($cells){
                    $cells->setFontSize(13);
                    $cells->setFontFamily('Times New Roman');
                
                });
                
                $sheet->setAutoSize(true);
                $sheet->setWidth([
                    'A'=>33,
                    'B'=>11,
                    'C'=>37,
                    'D'=>13,
                    'E'=>30,
                    'F'=>18,
                    'G'=>12
                ]);
                $sheet->setWrapText(['A','C','E','F']);

                $sheet->cells('A:G',function ($cells){
                     $cells->setValignment('center');
                });
                
                $sheet->mergeCells('A1:G1');
                $sheet->mergeCells('A2:G2');
                $sheet->mergeCells('A3:G3');
                $sheet->mergeCells('A6:G6');
                

                $sheet->cell('A1',function ($cell){
                    $cell->setValue('ФГКОУ "Санкт-Петербургский кадетский военный корпус МО РФ"');
                    $cell->setAlignment('center'); 
                    $cell->setBackground('D9D9D9');
                    $cell->setFont(['bold'=>true]);
                });
                $sheet->cell('A2',function ($cell) use($class){
                    $cell->setValue('Кадеты из '.$class->nameClass);
                    $cell->setAlignment('center');
                    $cell->setFont(['bold'=>true]);
                    $cell->setBackground('#D9D9D9');
                });
                $sheet->cell('A3',function ($cell) use($class){
                    $cell->setValue('Классный руководитель: '.$class->employee->getFullNameAttribute());
                    $cell->setAlignment('center'); 
                    $cell->setBackground('D9D9D9');
                });
                $sheet->cell('A6',function ($cell){
                    $cell->setValue('ФИО Кадета');
                    $cell->setAlignment('center'); 
                    $cell->setBackground('#BFBFBF');
                    $cell->setFont(['bold'=>true]);
                });
               $sheet->fromArray($colection, null, 'A7', true, false);
            });
        })->export('xls');
	LogController::addLog('Кадеты','Экспорт кадетов');
        return redirect()->back();
    }
    
    public function exportPrepods(Request $request){
        $collection = collect();
        $var = $this->getData();
        
        foreach ($var as $part){
            foreach($part->users as $user){
                $collection->push(['name'=>$user->getFullNameAttribute(),
                    'event'   =>$part->event->nameEvent,
                    'reach'   =>$part->reach->nameReach,
                    'date'    =>$part->dataEvent,
                    'subject' =>$part->subject->nameSubject,
                    'kadet'   =>$part->kadet->getFullNameAttribute(),
                    ]);
          }    
        }
        $colection = $collection->sortBy('name')->groupBy('name')->flatten(1);
        
        $ex = Excel::create('отчет по преподавателям',function ($excel) use($colection){
           $excel->setTitle('отчет по преподавателям');
           $excel->setCreator(Auth::user()->name);
           $excel->setCompany('SPBKK');
           $excel->setDescription('SPBKK');
           
            $excel->sheet('Sheetname', function($sheet) use($colection){
                $sheet->cells('A:G',function($cells){
                    $cells->setFontSize(13);
                    $cells->setFontFamily('Times New Roman');
                
                });
                
                $sheet->setAutoSize(false);
                $sheet->setWidth([
                    'A'=>33,
                    'B'=>50,
                    'C'=>27,
                    'D'=>13,
                    'E'=>30,
                    'F'=>33,
                    //'G'=>12
                ]);
                $sheet->setWrapText(['A','B','C','E','F']);

                $sheet->cells('A:G',function ($cells){
                     $cells->setValignment('center');
                });
                
                $sheet->mergeCells('A1:F1');
                $sheet->mergeCells('A2:F2');
                $sheet->mergeCells('A3:F3');
                //$sheet->mergeCells('A6:G6');
                

                $sheet->cell('A1',function ($cell){
                    $cell->setValue('ФГКОУ "Санкт-Петербургский кадетский военный корпус МО РФ"');
                    $cell->setAlignment('center'); 
                    $cell->setBackground('D9D9D9');
                    $cell->setFont(['bold'=>true]);
                });
                 $sheet->cell('A2',function ($cell){
                    $cell->setValue(' ');
                    $cell->setAlignment('center');
                    $cell->setFont(['bold'=>true]);
                    $cell->setBackground('#D9D9D9');
                });
                $sheet->cell('A3',function ($cell){
                    $cell->setValue('Отчет по преподавателям');
                    $cell->setAlignment('center');
                    $cell->setFont(['bold'=>true]);
                    $cell->setBackground('#D9D9D9');
                });
                
                
                $sheet->cell('A6',function ($cell){
                    $cell->setValue('ФИО преподователя');
                    $cell->setAlignment('center'); 
                    $cell->setBackground('#BFBFBF');
                    $cell->setFont(['bold'=>true]);
                });
                $sheet->cell('B6',function ($cell){
                    $cell->setValue('Мероприятие');
                    $cell->setAlignment('center'); 
                    $cell->setBackground('#BFBFBF');
                    $cell->setFont(['bold'=>true]);
                });
                $sheet->cell('C6',function ($cell){
                    $cell->setValue('Занятое место');
                    $cell->setAlignment('center'); 
                    $cell->setBackground('#BFBFBF');
                    $cell->setFont(['bold'=>true]);
                });
                $sheet->cell('D6',function ($cell){
                    $cell->setValue('Дата');
                    $cell->setAlignment('center'); 
                    $cell->setBackground('#BFBFBF');
                    $cell->setFont(['bold'=>true]);
                });
                $sheet->cell('E6',function ($cell){
                    $cell->setValue('Предмет');
                    $cell->setAlignment('center'); 
                    $cell->setBackground('#BFBFBF');
                    $cell->setFont(['bold'=>true]);
                });
                $sheet->cell('F6',function ($cell){
                    $cell->setValue('ФИО Кадета');
                    $cell->setAlignment('center'); 
                    $cell->setBackground('#BFBFBF');
                    $cell->setFont(['bold'=>true]);
                });
                
               $sheet->fromArray($colection, null, 'A7', true, false);
            });
        })->export('xls');
    }
}
