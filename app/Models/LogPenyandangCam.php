<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogPenyandangCam extends Model
{
    protected $fillable = [
        'penyandang_id',
        'folder_name'
    ];

    public function penyandang()
    {
        return $this->belongsTo(Penyandang::class);
    }
}
