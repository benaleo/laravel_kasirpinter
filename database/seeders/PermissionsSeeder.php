<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'users.index' => 'View users list',
            'users.create' => 'Create new user',
            'users.read' => 'View user details',
            'users.update' => 'Update user',
            'users.delete' => 'Delete user',
            'roles.index' => 'View roles list',
            'roles.create' => 'Create new role',
            'roles.read' => 'View role details',
            'roles.update' => 'Update role',
            'roles.delete' => 'Delete role',
        ];

        foreach ($permissions as $name => $description) {
            Permission::firstOrCreate([
                'name' => $name
            ], [
                'description' => $description
            ]);
        }
    }
}
