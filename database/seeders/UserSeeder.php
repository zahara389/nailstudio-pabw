<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name'       => 'Admin Sistem',
                'email'      => 'admin@example.com',
                'username'   => 'admin',
                'password'   => Hash::make('password123'),
                'role'       => 'admin',
                'photo'      => null,
                'status'     => 'active',
                'last_login' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name'       => 'Member Satu',
                'email'      => 'member1@example.com',
                'username'   => 'member1',
                'password'   => Hash::make('password123'),
                'role'       => 'member',
                'photo'      => null,
                'status'     => 'active',
                'last_login' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
