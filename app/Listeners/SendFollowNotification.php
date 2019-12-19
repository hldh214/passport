<?php

namespace App\Listeners;

use App\Events\Follow;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendFollowNotification
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
     * @param  Follow  $event
     * @return void
     */
    public function handle(Follow $event)
    {
        //
    }
}
