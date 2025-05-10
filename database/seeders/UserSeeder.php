<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(['email' => 'benaleo@gmail.com'], [
            'name' => 'benaleo',
            'email' => 'benaleo@gmail.com',
            'password' => Hash::make('kosongan'),
            'role_id' => Role::where('name', 'superuser')->first()->secure_id,
        ]);
    }
}
