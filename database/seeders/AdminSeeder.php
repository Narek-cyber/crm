<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'John Doe',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('Ab123456789'),
            ],
            [
                'name' => 'Jenna Doe',
                'email' => 'admin_1@gmail.com',
                'password' => Hash::make('Ab123456789'),
            ],
        ];

        $role = Role::findByName('admin');

        foreach ($admins as $admin) {
            User::query()->firstOrCreate(
                ['email' => $admin['email']],
                ['name' => $admin['name'], 'password' => $admin['password']]
            )->assignRole($role);
        }
    }
}
