<?php
namespace App\Http\Sections;

use SleepingOwl\Admin\Contracts\DisplayInterface;
use SleepingOwl\Admin\Contracts\FormInterface;
use SleepingOwl\Admin\Section;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminDisplayFilter;
use SleepingOwl\Admin\Contracts\Initializable;
/**
 * Class User
 *
 * @property \App\User $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class User extends Section
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
    protected $title = 'Пользователи';

    /**
     * @var string
     */
    protected $alias = 'users';
    
    protected  $model ='\App\user';


    /**
     * @return DisplayInterface
     */
    public function onDisplay()
            
    { 
        

        $display=AdminDisplay::datatables()/*->with('users')*/
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns(
                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumn::text('LastName', 'Фамилия'),
                AdminColumn::text('FirstName', 'Имя'),
                AdminColumn::text('SecondName', 'Отчество'),
                AdminColumn::link('name', 'Логин')->setWidth('200px'),
                AdminColumn::text('is_active','Активность')
            );    
       
                return $display;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id, \Symfony\Component\HttpFoundation\Request $request)
    {
        $button = AdminForm::panel()->getButtons()->hideResetButton()->hideDeleteButton();
       // dd($button);
        
        if ($request->getPathInfo()=='/admin/users/'.$id.'/passwordedit'){
             return AdminForm::panel()->addBody([
            AdminFormElement::password('password', 'Пароль')->required()->hashWithBcrypt(),
                 ])->setAction('/admin/users/'.$id.'/passwordedit')->setButtons($button);
        } else {
            $button = AdminForm::panel()->getButtons()->showResetButton();
        return AdminForm::panel()->addBody([
            AdminFormElement::text('LastName', 'Фамилия')->required(),
            AdminFormElement::text('FirstName', 'Имя')->required(),
            AdminFormElement::text('SecondName', 'Отчество')->required(),
            AdminFormElement::text('post','Занимаемая должность'),
            AdminFormElement::text('name','Логин')->setReadOnly(1),
            AdminFormElement::checkbox('work','Рабочий'),
            AdminFormElement::checkbox('teacher','Учитель'),
            AdminFormElement::checkbox('mentor','Воспитатель'),  
            AdminFormElement::checkbox('is_active','Активность'),
            AdminFormElement::checkbox('is_admin','Администратор'),
            ])->setButtons($button);
        }
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
          return AdminForm::panel()->addBody([
            AdminFormElement::text('LastName', 'Фамилия')->required(),
            AdminFormElement::text('FirstName', 'Имя')->required(),
            AdminFormElement::text('SecondName', 'Отчество')->required(),
            AdminFormElement::text('post','Занимаемая должность'),
            AdminFormElement::text('name','Логин')->unique()->required(),
            AdminFormElement::password('password', 'Пароль')->required()->hashWithBcrypt(),
            AdminFormElement::checkbox('work','Рабочий')->setDefaultValue(1),
            AdminFormElement::checkbox('teacher','Учитель'),
            AdminFormElement::checkbox('mentor','Воспитатель'),  
            AdminFormElement::checkbox('is_active','Активность')->setDefaultValue(1),
            AdminFormElement::checkbox('is_admin','Администратор'),
            ]);
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
