<?php

namespace Tests\Feature;

use App\Post;
use Tests\TestCase;

class PostCreationTest extends TestCase
{

    /** @test */
    public function a_guest_user_cannot_see_post_creation_from()
    {
        //arrange
        $this->withExceptionHandling();

        // act
        $response = $this->get(route('posts.create'));

        // assert
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function a_guest_user_cannot_save_posts()
    {
        //arrange
        $this->withExceptionHandling();

        // act
        $response = $this->post(route('posts.store'));

        // assert
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function a_logged_in_user_can_see_post_creation_form()
    {
        // arrange
        $this->signIn();

        // act
        $response = $this->get(route('posts.create'));

        // assert
        $response->assertViewIs('posts.create');
        $response->assertSee('Create a new post');
    }

    /** @test */
    public function a_logged_in_user_can_save_new_post()
    {
        // arrange
        $this->signIn();

        $postData = make(Post::class, null, ['user_id' => auth()->id()])->toArray();

        // act
        $response = $this->post(route('posts.store'), $postData);

        // assert
        $this->assertDatabaseHas('posts', $postData);
        $response->assertRedirect(route('posts.show', Post::first()));
    }

    /** @test */
    public function certain_fields_are_obligatory()
    {
        // arrange
        $this->signIn()->withExceptionHandling();

        // act
        $response = $this->post(route('posts.store'), []);

        // assert
        $response->assertSessionHasErrors(['title', 'category_id']);
        // category_id
    }
}
