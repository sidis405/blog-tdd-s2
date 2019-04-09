<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Acme\Models\Post;
use Acme\Models\Category;
use Illuminate\Support\Collection;

class CategoryTest extends TestCase
{
    /** @test */
    public function a_category_has_many_posts()
    {
        // arrange
        $category = create(Category::class);
        $posts = create(Post::class, 2, [
            'category_id' => $category->id
        ]);

        // act
        $category->load('posts');

        // assert
        $this->assertInstanceOf(Collection::class, $category->posts);
        $this->assertInstanceOf(Post::class, $category->posts->first());
    }
}
