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
        #Employees table seeder
       /* DB::table('employees')->insert([
            'name' => 'Super User',
            'email' => 'test@test.com',
            'password' => bcrypt('123456'),
        ]); */

        #individuals table seeder
        /* DB::table('individuals')->insert([
            'name' => 'Indi User 1',
            'email' => 'da@da.da',
            'password' => bcrypt('123456'),
        ]); */

        #Roles table seeder
        /* DB::table('roles')->insert([
            'title' => 'Administrator',
        ]);

        DB::table('roles')->insert([
            'title' => 'Employee',
        ]); */

        # Priorities table seeder
        DB::table('priorities')->insert([
            'name' => 'Низкий',
        ]);

        DB::table('priorities')->insert([
            'name' => 'Средний',
        ]);

        DB::table('priorities')->insert([
            'name' => 'Высокий',
        ]);

        # Statuses table seeder
        DB::table('statuses')->insert([
            'name' => 'Ожидает рассмотрения',
        ]);

        DB::table('statuses')->insert([
            'name' => 'Отклонена',
        ]);

        DB::table('statuses')->insert([
            'name' => 'В работе (назначен исполнитель)',
        ]);

        
        

        # legals table seeder
        DB::table('legals')->insert([
            'name' => 'Legal Client 1',
            'email' => 'test1@test.com',
            'password' => bcrypt('123456'),
        ]);


        # Priorities
        DB::table('priorities')->insert([
            'name' => 'Низкий',
        ]);

        DB::table('priorities')->insert([
            'name' => 'Средний',
        ]);

        DB::table('priorities')->insert([
            'name' => 'Высокий',
        ]);
    }
}
