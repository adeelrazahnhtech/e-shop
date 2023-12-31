<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'first_name' => 'Waqas',
            'last_name' => 'Qureshi',
            'email' => 'admin@gmail.com',
            'role' => 1,
            'email_verified_at' => 1,
            'password' => bcrypt('12345'),
        ]);
    }
}
