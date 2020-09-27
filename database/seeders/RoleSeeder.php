<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('roles')->insert(
            [
                ['role_name' => 'ADMIN'],
                ['role_name' => 'PENGAWAS'],
                ['role_name' => 'PASLON'],
                ['role_name' => 'USER'],
            ]
        );
    }
}