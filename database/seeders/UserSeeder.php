<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
   public function run(): void
    {
       
        // Crea el usuario administrador
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'], // Evita duplicados
            [
                'name' => 'Admin',
                'password' => Hash::make('123456'), // Cambia 'password' por una contraseña segura
            ]
        );
        // Asigna el rol de administrador al usuario administrador
        if (!$adminUser->roles()->exists()) {
            $adminUser->roles()->attach(Role::where('name','ADMIN')->first());
        }
        // Crea el usuario normal
        $normalUser = User::firstOrCreate(
            ['email' => 'user@example.com'], // Evita duplicados
            [
                'name' => 'User',
                'password' => Hash::make('123456'), // Cambia 'password' por una contraseña segura
            ]
        );

        // Asigna el rol de usuario normal al usuario normal
        if (!$normalUser->roles()->exists()) {
            $normalUser->roles()->attach(Role::where('name','USER')->first());
        }
    }
}
