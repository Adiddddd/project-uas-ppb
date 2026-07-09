<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisGudang extends Model
{
    protected $fillable = [
        'nama_jenis_gudang'
    ];

    public function gudangs()
    {
        return $this->hasMany(Gudang::class, 'id_jenis_gudang');
    }
}