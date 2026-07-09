<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{
    protected $fillable = [
        'nama_gudang',
        'id_jenis_gudang',
        'luas_gudang',
        'volume_gudang',
        'keterangan'
    ];

    public function jenisGudang()
    {
        return $this->belongsTo(JenisGudang::class, 'id_jenis_gudang');
    }
}