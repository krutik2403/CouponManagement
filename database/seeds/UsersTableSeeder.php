<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'is_admin' => 1,
                'name' => 'Jon Snow',
                'email' => 'admin@admin.com',
                'password' => bcrypt('12345678')
            ],
            [
                'is_admin' => 0,
                'name' => 'Daenerys Targaryen',
                'email' => 'mem   ber@example.com',
                'password' => bcrypt('12345678')
            ]
        ]);
    }
}
