<?php

namespace Acme\Models;

use Illuminate\Database\Eloquent\Model;
use Spiritix\LadaCache\Database\LadaCacheTrait;

class Category extends Model
{
    // use LadaCacheTrait;
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
