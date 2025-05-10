<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleHasPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = \App\Models\Permission::all();
        \App\Models\Role::where('name', 'superuser')->first()->permissions()->sync($permissions->pluck('id'));
    }
}
