<?php

namespace Acme\Listeners;

use Acme\Jobs\SendUpdateJob;
use Acme\Events\PostWasUpdated;

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
