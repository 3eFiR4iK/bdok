<?php

namespace App\Http\Sections;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use AdminColumn;

use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminDisplayFilter;
use SleepingOwl\Admin\Contracts\Initializable;

/**
 * Class Log
 *
 * @property \App\Log $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Log extends Section
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
    protected $title='Лог действий пользователей';

    /**
     * @var string
     */
    protected $alias='logs';

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
      $display=AdminDisplay::datatables()->with('users')
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns(
                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumn::text('users.fullName', 'Фио пользователя'),
                AdminColumn::text('action','действие'),
                AdminColumn::datetime('date','Дата'),
                AdminColumn::text('section','раздел')
               
            )->setOrder([[0,'desc']]);   
      $control=$display->getColumns()->getControlColumn(); 
      $control->setEditable(false);

      return $display;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        // todo: remove if unused
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
