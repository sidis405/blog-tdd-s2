<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class PostCreationTest extends TestCase
{

    /** @test */
    public function a_guest_user_cannot_save_posts()
    {
        //arrange
        $this->withExceptionHandling();

        // act
        $response = $this->postJson(route('api.posts.store'));

        // assert
        $response->assertStatus(401);
    }


    /** @test */
    public function a_logged_in_user_can_save_new_post()
    {
        // arrange
        $this->signInApi();

        $postData = [
            'title' => 'wtf',
            'category_id' => 1
        ];

        // act
        $response = $this->apiCall('POST', route('api.posts.store'), $postData);

        // assert
        $this->assertDatabaseHas('posts', $postData);
        $response->assertStatus(201);
    }

    /** @test */
    public function certain_fields_are_obligatory()
    {
        // arrange
        $this->signInApi()->withExceptionHandling();

        // act
        $response = $this->apiCall('POST', route('api.posts.store'), []);

        // assert
        $response->assertJsonStructure([
            'errors' => [
                'title',
                'category_id',
            ]
        ]);
        // category_id
    }
}
