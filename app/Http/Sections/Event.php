<?php

namespace App\Http\Sections;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use AdminColumn;
use App\Http\Controllers\lib\LogController;
use App\level;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminDisplayFilter;
use SleepingOwl\Admin\Contracts\Initializable;

/**
 * Class Event
 *
 * @property \App\Event $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Event extends Section
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
    protected $title='мероприятия';

    /**
     * @var string
     */
    protected $alias = 'events';
    
    protected  $model ='\App\Event';

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
       $display=AdminDisplay::datatables()->with('level')
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns(
                AdminColumn::text('account', '#')->setWidth('30px'),
                AdminColumn::text('nameEvent', 'Название мероприятия')
               
            );   
       $control = $display->getColumns()->getControlColumn();
       $link = new \SleepingOwl\Admin\Display\ControlLink(function (\Illuminate\Database\Eloquent\Model $model) {
            return '/admin/events/'.$model->getKey().'/edit'; // Генерация ссылки
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
            AdminFormElement::text('nameEvent', 'Имя мероприятия')->required()
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
