<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MTag extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tags', 'tag_id', 'post_id');
    }
}
