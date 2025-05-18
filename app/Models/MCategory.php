<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
