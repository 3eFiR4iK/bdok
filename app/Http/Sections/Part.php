<?php

namespace App\Http\Sections;

use SleepingOwl\Admin\Contracts\DisplayInterface;
use SleepingOwl\Admin\Contracts\FormInterface;
use SleepingOwl\Admin\Section;

//use App\Kadet;


use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminDisplayFilter;
use SleepingOwl\Admin\Contracts\Initializable;

/**
 * Class Part
 *
 * @property \App\Part $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Part extends Section
{
    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title='Достижения кадетов';

    /**
     * @var string
     */
    protected $alias;
    /**
     *
     * @var string 
     */
    protected $model='\App\Part';

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        
        $display=AdminDisplay::datatables()->with('users');
        
            $display->setHtmlAttribute('class', 'table-primary')
            ->setColumns(
                AdminColumn::text('id_part', '#'),
                AdminColumn::text('kadet.fullName', 'Фио кдета'),
                AdminColumn::custom('Класс', function ($query){ 
                    
                    $create = explode('-',$query->kadet->created_at);
                    return $query->nClass.' (-'.$create[0].')';
                    
                })->setWidth(80),
                AdminColumn::text('event.nameEvent', 'Мероприятие'),
                AdminColumn::text('Level.nameLevel','Уровень'),
                AdminColumn::text('reach.nameReach', 'Место'),
                AdminColumn::datetime('dataEvent','Дата проведения')->setFormat('d.m.Y'),
                AdminColumn::text('subject.nameSubject', 'Предмет'),
                AdminColumn::lists('users.fullname', 'Куратор'),
                AdminColumn::image('diploma', 'Фото')
               
            )->setOrder([[0,'desc']]);   
        
         $control = $display->getColumns()->getControlColumn();
       $link = new \SleepingOwl\Admin\Display\ControlLink(function (\Illuminate\Database\Eloquent\Model $model) {
            return '/admin/parts/'.$model->getKey().'/edit'; // Генерация ссылки
         }, 'Редактировать', 50);
       $link->setIcon('fa fa-pencil');
       $link->setHtmlAttribute('class', 'btn btn-xs btn-primary');
       $link->hideText();
       $control->addButton($link);
       
        return $display;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
          return AdminForm::panel()->addBody([
            AdminFormElement::select('accKadet','Кадет', \App\Kadet::class)->setDisplay('fullName')->required(),
            AdminFormElement::text('nClass','Класс')->required(),
            AdminFormElement::select('accEvent','Мероприятие', \App\event::class)->setDisplay('nameEvent')->required(),
            AdminFormElement::select('accLevel','уровень', \App\Level::class)->setDisplay('nameLevel')->required(),
            AdminFormElement::select('accReach','Занятое место', \App\Reach::class)->setDisplay('nameReach')->required(),
            AdminFormElement::date('dataEvent','Дата проведения')->required(),
            AdminFormElement::select('accSubject','Предмет', \App\Subject::class)->setDisplay('nameSubject')->required(),
            AdminFormElement::multiselect('users','Куратор', \App\User::class)->setDisplay('fullName')->required(),
            AdminFormElement::image('diploma','Фото')
             
                ]);
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }

    /**
     * @return void
     */
    public function onDelete($id)
    {
        // todo: remove if unused
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // todo: remove if unused
    }
}
