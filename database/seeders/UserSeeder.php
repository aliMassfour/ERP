<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'admin',
            'salary' => 2000
        ]);
        Role::create([
            'name' => 'employee',
            'salary' => 1000
        ]);
        Role::create([
            'name' => 'accountant',
            'salary' => '10000'
        ]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'points' => 0,
            'role_id' => 1,
        ]);
        User::create([
            'name' => 'Ali',
            'email' => 'employee@example.com',
            'username' => 'Ali Assfour',
            'password' => Hash::make('employee'),
            'points' => 0,
            'role_id' => 2,
        ]);
        User::create([
            'name' => 'accountant',
            'email' => 'accountant@gmail.com',
            'username' => 'accountant',
            'password' => Hash::make('accountant'),
            'points' => 0,
            'role_id' => 3

        ]);
    }
}
