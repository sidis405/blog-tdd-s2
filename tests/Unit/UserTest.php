<?php

namespace Tests\Unit;

use Tests\TestCase;
use Acme\Models\Post;
use Acme\Models\User;
use Acme\Models\Message;
use Illuminate\Support\Collection;

class UserTest extends TestCase
{
    /** @test */
    public function user_has_many_posts()
    {
        // arrange
        $user = create(User::class);
        $posts = create(Post::class, 3, [ 'user_id' => $user->id ]);

        // act
        $user->load('posts');

        // assert
        $this->assertInstanceOf('Illuminate\Support\Collection', $user->posts);
        $this->assertInstanceOf(Post::class, $user->posts->first());
    }

    /** @test */
    public function user_has_many_messages()
    {
        // arrange
        $user = create(User::class);
        $messages = create(Message::class, 3, [
            'user_id' => $user->id
        ]);

        // act
        $user->load('messages');

        // assert
        $this->assertInstanceOf(Collection::class, $user->messages);
        $this->assertInstanceOf(Message::class, $user->messages->first());
    }
}
