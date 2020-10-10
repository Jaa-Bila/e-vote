<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert(
            [
                ['name' => 'Dashboard',],
                ['name' => 'Daftar Admin'],
                ['name' => 'Daftar Pengawas'],
                ['name' => 'Daftar Calon'],
                ['name' => 'Daftar Pemilih'],
                ['name' => 'Daftar Data Pemilih'],
                ['name' => 'Sudah Memilih'],
                ['name' => 'Belum Memilih'],
                ['name' => 'Rekap Suara Masuk'],
                ['name' => 'Rekap Perolehan'],
                ['name' => 'Laporan Hasil Perolehan'],
                ['name' => 'Pengguna'],
                ['name' => 'Pengaturan Web'],
            ]
        );
    }
}
