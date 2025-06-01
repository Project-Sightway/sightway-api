<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\SupabaseService;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'category_id',
        'views',
        'img_url'
    ];

    public function category()
    {
        return $this->belongsTo(MCategory::class);
    }

    public function tags()
    {
        return $this->belongsToMany(MTag::class, 'post_tags', 'post_id', 'tag_id');
    }

    public function getImgUrlAttribute($value)
    {
        if (!$value) {
            return null;
        }

        $supabase = new SupabaseService('posts');
        return $supabase->getSignedUrl($value);
    }
}
