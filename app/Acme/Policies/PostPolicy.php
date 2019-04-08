<?php

namespace Acme\Policies;

use Acme\Models\Post;
use Acme\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Post $post)
    {
        return $post->user_id == $user->id;
    }

    public function delete(User $user, Post $post)
    {
        return $post->user_id == $user->id;
    }
}
