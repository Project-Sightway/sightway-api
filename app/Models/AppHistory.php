<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppHistory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'file_apk',
        'file_ipa',
    ];
}
