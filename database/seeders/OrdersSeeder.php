<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class OrdersSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = 10;

        for ($i = 0; $i < $count; $i++) {
            $customer = Customer::inRandomOrder()->first();
            $order = $customer->orders()->create([
                'created_by' => User::first()->id
            ]);
            
            $items_length = rand(1, 5);
            for($x = 0; $x < $items_length; $x++) {
                $order->order_items()->create([
                    'product_id' => Product::inRandomOrder()->first()->id,
                    'quantity' => rand(1, 5)
                ]);
            }
        }
    }
}
