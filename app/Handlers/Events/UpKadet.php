<?php

namespace App\Handlers\Events;

use App\Events\UpdateKadet;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpKadet
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UpdateKadet  $event
     * @return void
     */
    public function handle(UpdateKadet $event)
    {
        //dump($event);
    }
}
