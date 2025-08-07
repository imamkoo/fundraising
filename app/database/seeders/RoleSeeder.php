<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ownerRole = Role::create([
            'name' => 'owner',
            'guard_name' => 'web',
        ]);

        $fundraiserRole = Role::create([
            'name' => 'fundraiser',
            'guard_name' => 'web',
        ]);

        $userOwner = User::create([
            'name' => 'Owner',
            'avatar' => 'images/default-avatar.png',
            'email' => 'owner@gmail.com',
            'password' => Hash::make('123123123'),
        ]);

        $userOwner->assignRole($ownerRole);

    }
}
