<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'create-tariff',
            ],
            [
                'name' => 'update-tariff',
            ],
            [
                'name' => 'delete-tariff',
            ],
        ];

        $adminRole = Role::findByName('admin');

        foreach ($permissions as $permission) {
            Permission::query()->firstOrCreate(
                ['name' => $permission['name']],
                ['name' => $permission['name']]
            );
            $adminRole->givePermissionTo($permission['name']);
        }
    }
}
