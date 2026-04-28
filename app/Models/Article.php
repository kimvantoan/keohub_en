<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'thumbnail',
        'meta_title',
        'meta_description',
        'is_published',
        'published_at'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
