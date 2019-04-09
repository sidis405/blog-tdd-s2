<?php

namespace Acme\Models;

use Illuminate\Support\Str;
use Acme\Events\PostWasUpdated;
use Illuminate\Database\Eloquent\Model;
use Spiritix\LadaCache\Database\LadaCacheTrait;

class Post extends Model
{
    // use LadaCacheTrait;
    protected $guarded = [];

    // public static function boot()
    // {
    //     parent::boot();

    //     static::updated(function ($post) {
    //         event(new PostWasUpdated($post));
    //     });
    // }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Mutators
     */

    public function setTitleAttribute($title)
    {
        $this->attributes['title'] = $title;
        $this->attributes['slug'] = Str::slug($title);
    }
}
