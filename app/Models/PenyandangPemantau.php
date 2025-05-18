<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenyandangPemantau extends Model
{
    protected $table = "penyandang_pemantau";
    protected $fillable = ['penyandang_id', 'pemantau_id', 'relation'];

    public function penyandang()
    {
        return $this->belongsTo(Penyandang::class);
    }

    public function pemantau()
    {
        return $this->belongsTo(Pemantau::class);
    }
}
