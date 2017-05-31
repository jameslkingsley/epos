<?php

namespace App\Listeners;

use App\Events\BasketChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DealWatcher
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
     * @param  BasketChanged  $event
     * @return void
     */
    public function handle(BasketChanged $event)
    {
        $event->basket->checkForDeals();
    }
}
