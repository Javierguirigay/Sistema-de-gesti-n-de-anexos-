<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'id' => 1,
                'remember_token' => null,
                'name' => 'Pascual Perales',
                'role' => 'admin',
                'cedula' => '26999999',
                'username' => 'm26999999',
                'email' => 'pascualperales@gmail.com',
                'password' => Hash::make('password'),
            ],
            [
                'id' => 2,
                'remember_token' => null,
                'name' => 'Diana Perales',
                'role' => 'teacher',
                'cedula' => '26999991',
                'username' => 'm26999991',
                'email' => 'dianaperales@gmail.com',
                'password' => Hash::make('password'),
            ],
        ];
        User::insert($users);
    }
}
