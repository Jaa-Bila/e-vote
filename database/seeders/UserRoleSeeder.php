<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('user_role')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('user_role')->insert([
            'user_id' => 1,
            'role_id' => 1,
        ]);
    }
}
