<?php

use SleepingOwl\Admin\Navigation\Page;

// Default check access logic
// AdminNavigation::setAccessLogic(function(Page $page) {
// 	   return auth()->user()->isSuperAdmin();
// });
//
// AdminNavigation::addPage(\App\User::class)->setTitle('test')->setPages(function(Page $page) {
// 	  $page
//		  ->addPage()
//	  	  ->setTitle('Dashboard')
//		  ->setUrl(route('admin.dashboard'))
//		  ->setPriority(100);
//
//	  $page->addPage(\App\User::class);
// });
//
// // or
//
// AdminSection::addMenuPage(\App\User::class)

return [
    [
        'title' => 'Logs',
        'icon'  => 'fa fa-dashboard',
        'url'   => 'admin/logs',
    ],


    [
       'title' => 'Пользователи',
        'icon' => 'fa fa-user',
       'url'   => 'admin/users',
    ],
    [
       'title' => 'Мероприятия',
        'icon' => 'glyphicon glyphicon-map-marker',
       'url'   => 'admin/events',
    ],
    [
        'title'=> 'Кадеты',
        'icon'=>'glyphicon glyphicon-user',
        'url'=>'admin/kadets',
    ],
    
    [
        'title'=> 'Достижения кадетов',
        'icon'=>'glyphicon glyphicon-tag',
        'url'=>'admin/parts',
    ]
];