<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::insert([
            ['name' => 'product_store'],
            ['name' => 'product_update'],
            ['name' => 'product_delete'],
            ['name' => 'seller_update'],
            ['name' => 'seller_delete'],
             ]);
    }
}
