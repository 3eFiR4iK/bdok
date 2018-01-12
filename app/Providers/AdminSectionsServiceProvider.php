<?php

namespace App\Providers;

use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as ServiceProvider;

class AdminSectionsServiceProvider extends ServiceProvider
{

    /**
     * @var array
     */
    protected $sections = [
        \App\User::class => 'App\Http\Sections\User',
        \App\Event::class=> 'App\Http\Sections\Event',
        \App\Kadet::class=> 'App\Http\Sections\Kadet',
        \App\Part::class=> 'App\Http\Sections\Part',
        \App\Log::class=> 'App\Http\Sections\Log',
    ];

    /**
     * Register sections.
     *
     * @return void
     */
    public function boot(\SleepingOwl\Admin\Admin $admin)
    {
    	//

        parent::boot($admin);
    }
}
