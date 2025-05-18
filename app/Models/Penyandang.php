<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyandang extends Model
{
    protected $table = "penyandang";
    protected $fillable = ["user_id", "blindstick_id"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pemantau()
    {
        return $this->belongsToMany(Pemantau::class, 'penyandang_pemantau', 'penyandang_id', 'pemantau_id');
    }

    public function logPenyandangStatus()
    {
        return $this->hasMany(LogPenyandangStatus::class);
    }

    public function logPenyandangMap()
    {
        return $this->hasMany(LogPenyandangMap::class);
    }

    public function logPenyandangCam()
    {
        return $this->hasMany(LogPenyandangCam::class);
    }

    public function blindstick()
    {
        return $this->belongsTo(Blindstick::class);
    }
}
