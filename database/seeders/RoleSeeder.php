<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = array_map(fn($role) => ['name' => $role->value], RolesEnum::cases());;

        foreach ($roles as $role) {
            Role::query()->firstOrCreate(
                ['name' => $role['name']],
                ['name' => $role['name']]
            );
        }
    }
}
