<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisGudangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jenis_gudangs')->insert([
            ['nama_jenis_gudang' => 'Gudang Utama'],
            ['nama_jenis_gudang' => 'Gudang Cabang'],
            ['nama_jenis_gudang' => 'Gudang Pendingin'],
            ['nama_jenis_gudang' => 'Gudang Transit'],
        ]);
    }
}