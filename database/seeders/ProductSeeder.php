<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::insert([
            [
                "id" => 100,
                "name" => "Black&Decker A7062 40 Parça Cırcırlı Tornavida Seti",
                "category_id" => 1,
                "price" => 120.75,
                "stock" => 10
            ],
            [
                'id' => 101,
                'name' => 'Reko Mini Tamir Hassas Tornavida Seti 32\'li',
                'category_id' => 1,
                'price' => 49.50,
                'stock' => 10,
            ],
            [
                'id' => 102,
                'name' => 'Viko Karre Anahtar - Beyaz',
                'category_id' => 2,
                'price' => 11.28,
                'stock' => 10,
            ],
            [
                'id' => 103,
                'name' => 'Legrand Salbei Anahtar, Alüminyum',
                'category_id' => 2,
                'price' => 22.80,
                'stock' => 10,
            ],
            [
                'id' => 104,
                'name' => 'Schneider Asfora Beyaz Komütatör',
                'category_id' => 2,
                'price' => 12.95,
                'stock' => 10,
            ]
        ]);
    }
}
