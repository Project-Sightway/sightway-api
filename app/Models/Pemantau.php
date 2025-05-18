<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemantau extends Model
{
    protected $table = "pemantau";
    protected $fillable = ["user_id"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function penyandang()
    {
        return $this->belongsToMany(Penyandang::class, "penyandang_pemantau", "pemantau_id", "penyandang_id");
    }
}
