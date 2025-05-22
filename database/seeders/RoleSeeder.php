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
         // Crea los roles si no existen
        Role::firstOrCreate(['name' => 'ADMIN','description' => 'administrador',]);
        Role::firstOrCreate(['name' => 'USER','description' => 'usuario normal',]);
    }
}
