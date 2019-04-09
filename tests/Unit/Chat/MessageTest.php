<?php

namespace Tests\Unit\Chat;

use Tests\TestCase;
use Acme\Models\User;
use Acme\Models\Message;

class MessageTest extends TestCase
{
    /** @test */
    public function message_belongs_to_a_user()
    {
        $message = create(Message::class);

        $this->assertInstanceOf(User::class, $message->user);
    }
}
