<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogPenyandangStatus extends Model
{
    protected $fillable = [
        'penyandang_id',
        'status',
        'description',
    ];

    public function penyandang()
    {
        return $this->belongsTo(Penyandang::class);
    }
}
