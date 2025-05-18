<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogPenyandangMap extends Model
{
    protected $fillable = [
        'penyandang_id',
        'latitude',
        'longitude',
    ];

    public function penyandang()
    {
        return $this->belongsTo(Penyandang::class);
    }
}
