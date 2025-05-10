<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'superuser',
            'admin'
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName], [
                'name' => $roleName,
            ]);
        }
    }
}
