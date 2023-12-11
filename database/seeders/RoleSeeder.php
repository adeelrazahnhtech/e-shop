<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['role_type' => 'Admin'],
            ['role_type' => 'Sub Admin'],
            ['role_type' => 'Seller'],
            ['role_type' => 'User']
        ]);

    }
}
