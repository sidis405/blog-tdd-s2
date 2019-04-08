<?php

namespace Tests\Unit;

use Tests\TestCase;
use Acme\Models\Post;
use Acme\Models\User;

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
}
