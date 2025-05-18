<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'category_id',
        'views'
    ];
    public function category()
    {
        return $this->belongsTo(MCategory::class);
    }
    public function tags()
    {
        return $this->belongsToMany(MTag::class, 'post_tags', 'post_id', 'tag_id');
    }
}
