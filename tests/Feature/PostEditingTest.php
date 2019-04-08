<?php

namespace Tests\Feature;

use App\Post;
use Tests\TestCase;
use App\Jobs\SendUpdateJob;
use App\Events\PostWasUpdated;
use App\Mail\APostWasUpdatedEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;

class PostEditingTest extends TestCase
{
    /** @test */
    public function guest_cannot_see_update_form()
    {
        // arrage
        $this->withExceptionHandling();
        $post = create(Post::class);

        // act
        $response = $this->get(route('posts.edit', $post));

        // assert
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function guest_cannot_update_post()
    {
        // arrage
        $this->withExceptionHandling();
        $post = create(Post::class);

        // act
        $response = $this->patch(route('posts.update', $post), []);

        // assert
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function author_user_can_see_update_form()
    {
        $this->signIn();
        // arrage
        $post = create(Post::class, null, ['user_id' => auth()->id()]);

        // act
        $response = $this->get(route('posts.edit', $post));

        // assert
        $response->assertSee('Editing post');
        $response->assertViewIs('posts.edit');
        $this->assertEquals($post->id, $response->viewData('post')->id);
    }

    /** @test */
    public function non_author_cannot_update_post()
    {
        // arrange
        $this->signIn()->withExceptionHandling();

        $post = create(Post::class);

        // act
        $response = $this->patch(route('posts.update', $post), []);

        // assert
        $response->assertStatus(403);
    }

    /** @test */
    public function non_author_cannot_see_update_form()
    {
        // arrange
        $this->signIn()->withExceptionHandling();

        $post = create(Post::class);

        // act
        $response = $this->get(route('posts.edit', $post));

        // assert
        $response->assertStatus(403);
    }

    /** @test */
    public function author_can_update_a_post()
    {
        [$post, $postData, $response] = $this->updatePost();

        $this->assertEquals($post->title, $postData['title']);

        $response->assertRedirect(route('posts.show', $post));
    }

    public function updatePost()
    {
        $this->signIn();
        $post = create(Post::class, null, ['user_id' => auth()->id()]);
        $postData = [
            'title' => 'Updated post',
            'category_id' => 1,
        ];

        $response = $this->patch(route('posts.update', $post), $postData);

        $post = $post->fresh();

        return [$post, $postData, $response];
    }

    /** @test */
    public function when_post_is_updated_event_is_raised()
    {
        Event::fake();

        [$post, $postData, $response] = $this->updatePost();

        // Event::assertDispatched(PostWasUpdated::class);
        Event::assertDispatched(PostWasUpdated::class, function ($event) use ($post) {
            return $event->post->id == $post->id;
        });
    }

    /** @test */
    public function when_post_is_updated_job_is_queued()
    {
        Queue::fake();

        [$post, $postData, $response] = $this->updatePost();

        // Queue::assertPushed(SendUpdateJob::class);
        Queue::assertPushed(SendUpdateJob::class, function ($job) use ($post) {
            return $job->post->id == $post->id;
        });
    }

    /** @test */
    public function when_post_is_updated_an_email_is_sent()
    {
        Mail::fake();

        [$post, $postData, $response] = $this->updatePost();

        // Mail::assertSent(APostWasUpdatedEmail::class);
        Mail::assertSent(APostWasUpdatedEmail::class, function ($mail) use ($post) {
            $mail->build();
            return $mail->hasTo($post->user->email) && $mail->subject == $post->title  . ' was updated';
        });
    }
}
