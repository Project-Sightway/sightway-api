<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlindStick extends Model
{
    protected $fillable = [
        'mac_address',
        'is_used'
    ];

    public function logBlindsticks()
    {
        return $this->hasMany(LogBlindstick::class);
    }

    public function penyandang()
    {
        return $this->hasOne(Penyandang::class);
    }
}
