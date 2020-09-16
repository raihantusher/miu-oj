<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
                [    'name' => "admin",
                    'email' =>'admin@admin.com',
                    'password' => bcrypt('admin1234'),
                ],
                [
                    'name' => "student",
                    'email' =>'student@admin.com',
                    'password' => bcrypt('admin1234'),
                ]
            ]
        );
    }
}
