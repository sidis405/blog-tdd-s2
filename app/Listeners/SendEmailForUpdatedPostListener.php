<?php

namespace App\Listeners;

use App\Jobs\SendUpdateJob;
use App\Events\PostWasUpdated;

class SendEmailForUpdatedPostListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(PostWasUpdated $event)
    {
        SendUpdateJob::dispatch($event->post);
    }
}
