<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            // Electrónica
            [
                'name' => 'Smartphone X9 Pro',
                'category' => 'Electrónica',
                'price' => 899.99,
                'stock' => 50
            ],
            [
                'name' => 'Tablet Galaxy Tab S7',
                'category' => 'Electrónica',
                'price' => 649.99,
                'stock' => 30
            ],
            [
                'name' => 'Auriculares Bluetooth Noise Cancelling',
                'category' => 'Electrónica',
                'price' => 199.99,
                'stock' => 100
            ],
            
            // Informática
            [
                'name' => 'Portátil Ultrabook 14"',
                'category' => 'Informática',
                'price' => 1299.99,
                'stock' => 25
            ],
            [
                'name' => 'Teclado Mecánico Gaming',
                'category' => 'Informática',
                'price' => 89.99,
                'stock' => 75
            ],
            [
                'name' => 'Monitor 27" 4K',
                'category' => 'Informática',
                'price' => 399.99,
                'stock' => 40
            ],
            
            // Oficina
            [
                'name' => 'Silla Ergonómica Ejecutiva',
                'category' => 'Oficina',
                'price' => 299.99,
                'stock' => 20
            ],
            [
                'name' => 'Escritorio Moderno 120cm',
                'category' => 'Oficina',
                'price' => 179.99,
                'stock' => 15
            ],
            [
                'name' => 'Organizador de Archivos',
                'category' => 'Oficina',
                'price' => 24.99,
                'stock' => 200
            ],
            
            // Hogar
            [
                'name' => 'Cafetera Programable',
                'category' => 'Hogar',
                'price' => 59.99,
                'stock' => 60
            ],
            [
                'name' => 'Robot Aspirador',
                'category' => 'Hogar',
                'price' => 349.99,
                'stock' => 18
            ],
            [
                'name' => 'Juego de Sábanas Algodón',
                'category' => 'Hogar',
                'price' => 39.99,
                'stock' => 120
            ]
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }

        $this->command->info('¡Artículos creados exitosamente!');
    }
}
