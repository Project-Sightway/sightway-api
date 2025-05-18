<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogBlindstick extends Model
{
    protected $fillable = [
        'blindstick_id',
        'status',
        'description'
    ];

    public function blindstick()
    {
        return $this->belongsTo(Blindstick::class);
    }
}
