<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $faker = Faker::create('es_ES'); // Configura Faker para datos en español

        // Tipos de clientes para variedad
        $clientTypes = [
            'Particular',
            'Empresa',
            'Autónomo',
            'Administración Pública'
        ];

        // Generar 20 clientes de ejemplo
        for ($i = 0; $i < 20; $i++) {
            $type = $clientTypes[array_rand($clientTypes)];
            
            // Ajustar name según tipo de cliente
            if ($type === 'Empresa') {
                $name = $faker->company;
                $lastname = '';
            } elseif ($type === 'Administración Pública') {
                $name = 'Ayuntamiento de ' . $faker->city;
                $lastname = '';
            } else {
                $name = $faker->firstName;
                $lastname = $faker->lastName . ' ' . $faker->lastName;
            }

            Client::create([
                'name' => $name,
                'lastname' => $type === 'Empresa' || $type === 'Administración Pública' ? null : $lastname,
                'type' => match($type) {
                    'Empresa' => 'empresa',
                    'Administración Pública' => 'administracion',
                    'Autónomo' => 'autonomo',
                    default => 'particular'
                },
                'direction' => $faker->streetAddress . ', ' . $faker->city,
                'phone' => $faker->phoneNumber,
                'email' => $type === 'Empresa' 
                    ? $faker->companyEmail 
                    : $faker->unique()->safeEmail,
            ]);
        }

        // Clientes específicos para testing
        Client::create([
            'name' => 'Juan',
            'lastname' => 'Pérez García',
            'type' => 'particular',
            'direction' => 'Calle Mayor 123, Madrid',
            'phone' => '+34 912 345 678',
            'email' => 'juan.perez@example.com',
        ]);

        Client::create([
            'name' => 'Tecnologías',
            'lastname' => 'Avanzadas SL',
            'type' => 'autonomo',
            'direction' => 'Avenida Innovación 45, Barcelona',
            'phone' => '+34 933 445 566',
            'email' => 'info@tecnologias-avanzadas.com',
        ]);

        $this->command->info('¡Clientes creados exitosamente!');
    }
}
