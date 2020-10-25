<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('users')->insert([
            'name' => 'Admin',
            'no_ktp' => '000001',
            'nik' => '3573472',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '2020-09-22',
            'jenis_kelamin' => 'laki-laki',
            'agama' => 'islam',
            'alamat' => 'Alamat',
            'pekerjaan' => 'pekerjaan',
            'provinsi' => 'Jawa Timur',
            'kabkota' => 'Surabaya',
            'desa_kelurahan' => '',
            'kecamatan' => '',
            'pendidikan_terakhir' => 'S1',
            'pengalaman_organisasi' => 'Tidak ada',
            'keterangan_tambahan' => null,
            'foto' => 'storage/image/user.jpg',
            'foto_pengawas' => 'storage/image/user.jpg',
            'status' => 1
        ]);


    }
}
