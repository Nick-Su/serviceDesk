<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
            'name' => 'Super User',
            'email' => 'test@test.com',
            'password' => bcrypt('123456'),
        ]);

        DB::table('legals')->insert([
            'name' => 'Legal Client',
            'email' => 'test1@test.com',
            'password' => bcrypt('123456'),
        ]);

        DB::table('individuals')->insert([
            'name' => 'Indi User 1',
            'email' => 'da@da.da',
            'password' => bcrypt('123456'),
        ]);
    }
}
