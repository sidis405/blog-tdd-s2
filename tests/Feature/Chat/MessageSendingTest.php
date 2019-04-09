<?php

namespace Tests\Feature\Chat;

use Tests\TestCase;
use Acme\Models\Message;
use Acme\Events\NewChatMessage;
use Illuminate\Support\Facades\Event;

class MessageSendingTest extends TestCase
{
    /** @test */
    public function guest_user_cannot_send_message()
    {
        // arrange
        $this->withExceptionHandling();

        // act
        $response = $this->postJson(route('messages.store'), []);

        // assert
        $response->assertStatus(401);
    }

    /** @test */
    public function logged_in_user_can_send_message()
    {
        // arrange
        $this->signIn();

        // act
        $response = $this->postJson(route('messages.store'), [
            'body' => 'Lorem ipsum'
        ]);

        // assert
        $response->assertStatus(201);
        $this->assertDatabaseHas('messages', [
            'body' => 'Lorem ipsum'
        ]);

        $response->assertJsonFragment(['body' => 'Lorem ipsum']);
    }

    /** @test */
    public function when_message_is_created_an_event_is_sent_in_broadcast()
    {
        Event::fake();

        // arrange
        $this->signIn();

        // act
        $response = $this->postJson(route('messages.store'), [
            'body' => 'Lorem ipsum'
        ]);

        // assert
        $message = Message::first();

        // Event::assertDispatched(NewChatMessage::class);
        Event::assertDispatched(NewChatMessage::class, function ($event) use ($message) {
            return $event->message->id == $message->id;
        });
    }
}
