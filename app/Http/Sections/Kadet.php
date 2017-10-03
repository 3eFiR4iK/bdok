<?php

namespace App\Http\Sections;

use SleepingOwl\Admin\Contracts\DisplayInterface;
use SleepingOwl\Admin\Contracts\FormInterface;
use SleepingOwl\Admin\Section;
use App\KadetClass;
use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminDisplayFilter;
use SleepingOwl\Admin\Contracts\Initializable;

/**
 * Class Kadet
 *
 * @property \App\Kadet $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Kadet extends Section
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
    protected $title='Кадеты';

    /**
     * @var string
     */
    protected $alias;

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display=AdminDisplay::datatables()->with('KadetClass')
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns(
                AdminColumn::text('account', '#')->setWidth('30px'),
                AdminColumn::text('fullName', 'Фио кдета'),
                AdminColumn::datetime('birthdata','Дата рождения'),
                AdminColumn::custom('Класс', function ($query){ 
                    
                    $create = explode('-',$query->created_at);
                    return $query->KadetClass->nameClass.' (-'. create[0].'г.)';
                    
                })->setWidth(90),
                AdminColumn::custom('Учится',function ($model){
                    if($model->studyKK == 1){
                        $disp = "да";
                    } else 
                    {
                       $disp = $model->date_out;
                    }
                    return $disp;
                })
               
            );   
        return $display;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
//        $kad 
//       //if(\App\Kadet::find($id) )
        
//        $display =AdminForm::panel()->setItems(
//            AdminFormElement::columns()
//            ->addColumn(function() {
//                return [
//            AdminFormElement::text('KLastName', 'Фамилия')->required(),
//            AdminFormElement::text('KFirstName', 'Имя')->required(),
//            AdminFormElement::text('KSecondName', 'Отчество')->required(),
//            AdminFormElement::date('birthdata','Дата рождения')->required(),
//            AdminFormElement::select('accClass','Класс', KadetClass::class)->setDisplay('nameClass')->required()];}));
//         
//        
//            
//        $display->setItems(AdminFormElement::columns()->addColumn(
//        function (){return [
//        AdminFormElement::checkbox('studyKK','Учится'),
//            
//        ];}));
        
        return AdminForm::panel()->addBody([
            AdminFormElement::text('KLastName', 'Фамилия')->required(),
            AdminFormElement::text('KFirstName', 'Имя')->required(),
            AdminFormElement::text('KSecondName', 'Отчество')->required(),
            AdminFormElement::date('birthdata','Дата рождения')->required(),
            AdminFormElement::select('accClass','Класс', KadetClass::class)->setDisplay('nameClass')->required(),
            AdminFormElement::checkbox('studyKK','Учится')]);
                
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
