<?php

namespace Tests\Feature\Chat;

use Tests\TestCase;
use Acme\Models\Message;

class MessageListingTest extends TestCase
{
    /** @test */
    public function guest_user_cannot_see_messages()
    {
        // arrange
        $this->withExceptionHandling();

        // act
        $response = $this->getJson(route('messages.index'));

        // assert
        $response->assertStatus(401);
    }

    /** @test */
    public function authed_user_can_see_messages()
    {
        // arrange
        $this->signIn();
        $messages = create(Message::class, 2);

        // act
        $response = $this->getJson(route('messages.index'));

        // assert
        $response->assertStatus(200);

        foreach ($messages as $message) {
            $response->assertSee($message->body);
            $response->assertSee($message->user->name);
        }
    }
}
