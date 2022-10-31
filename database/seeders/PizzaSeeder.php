<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PizzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['pizza_name'=>'Original','small_price'=>8,'medium_price'=>9,'large_price'=>11],
            ['pizza_name'=>'Gimme the Meat','small_price'=>11,'medium_price'=>14.50,'large_price'=>16.50],
            ['pizza_name'=>'Veggie Delight','small_price'=>10,'medium_price'=>13,'large_price'=>15],
            ['pizza_name'=>'Make Mine Hot','small_price'=>11,'medium_price'=>13,'large_price'=>15],
        ];

        DB::table('pizzas')->insert($data);
    }
}
