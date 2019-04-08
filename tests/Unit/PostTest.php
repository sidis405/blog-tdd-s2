<?php

namespace Tests\Unit;

use Tests\TestCase;
use Acme\Models\Tag;
use Acme\Models\Post;
use Acme\Models\User;
use Acme\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class PostTest extends TestCase
{
    protected $post;

    public function setUp() : void
    {
        parent::setUp();

        $this->post = factory(Post::class)->create();
    }

    /** @test */
    public function post_belongs_to_user()
    {
        // act
        $this->post->load('user');

        // assert
        $this->assertInstanceOf(User::class, $this->post->user);
    }

    /** @test */
    public function post_belogns_to_a_category()
    {
        // act
        $this->post->load('category');

        // assert
        $this->assertInstanceOf(Category::class, $this->post->category);
    }

    /** @test */
    public function post_belongs_to_many_tags()
    {
        // arrange
        $tags = factory(Tag::class, 3)->create();
        $this->post->tags()->sync($tags);

        // act
        $this->post->load('tags');

        // assert
        $this->assertInstanceOf(Collection::class, $this->post->tags);
        $this->assertInstanceOf(Tag::class, $this->post->tags->first());
    }

    /** @test */
    public function posts_are_identified_by_slug()
    {
        $this->assertEquals($this->post->getRouteKeyName(), 'slug');
        // $this->assertTrue(strpos(route('posts.show', $this->post), $this->post->slug) > -1);
    }

    /** @test */
    public function posts_creates_own_slug()
    {
        $this->assertEquals($this->post->slug, Str::slug($this->post->title));
    }
}
