<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $order1 = new Order();
        $order1->customer_id = 1;
        $order1->total = 112.80;
        $order1->save();
        $order1->products()->attach(102, [
            'quantity' => 10,
            'unit_price' => 11.28,
            'total' => 112.80
        ]);

        $order2 = new Order();
        $order2->customer_id = 2;
        $order2->total = 219.75;
        $order2->save();
        $order2->products()->attach(101, [
            'quantity' => 2,
            'unit_price' => 49.50,
            'total' => 99.00
        ]);
        $order2->products()->attach(100, [
            'quantity' => 1,
            'unit_price' => 120.75,
            'total' => 120.75
        ]);

        $order3 = new Order();
        $order3->customer_id = 3;
        $order3->total = 1275.18;
        $order3->save();
        $order3->products()->attach(102, [
            'quantity' => 6,
            'unit_price' => '11.28',
            'total' => '67.68'
        ]);
        $order3->products()->attach(100, [
            'quantity' => 10,
            'unit_price' => '120.75',
            'total' => '1207.50'
        ]);
    }
}
