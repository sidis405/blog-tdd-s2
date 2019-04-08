<?php

namespace Tests\Unit;

use App\Post;
use App\User;
use Tests\TestCase;

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
        $this->assertInstanceOf('App\Post', $user->posts->first());
    }
}
