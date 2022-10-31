<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopppingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['pizza_id'=>1,'topping_name'=>'Cheese'],
            ['pizza_id'=>1,'topping_name'=>'Tomato sauce'],

            ['pizza_id'=>2,'topping_name'=>'Pepperoni'],
            ['pizza_id'=>2,'topping_name'=>'Ham'],
            ['pizza_id'=>2,'topping_name'=>'Chicken'],
            ['pizza_id'=>2,'topping_name'=>'Minced beef'],
            ['pizza_id'=>2,'topping_name'=>'Sausage'],
            ['pizza_id'=>2,'topping_name'=>'Bacon'],

            ['pizza_id'=>3,'topping_name'=>'Onions'],
            ['pizza_id'=>3,'topping_name'=>'Green peppers'],
            ['pizza_id'=>3,'topping_name'=>'Mushrooms'],
            ['pizza_id'=>3,'topping_name'=>'Sweetcorn'],

            ['pizza_id'=>4,'topping_name'=>'Chicken'],
            ['pizza_id'=>4,'topping_name'=>'Onions'],
            ['pizza_id'=>3,'topping_name'=>'Green peppers'],
            ['pizza_id'=>2,'topping_name'=>'Jalapeno peppers'],

            // ['pizza_id'=>null,'topping_name'=>'Jalapeno peppers'],
            // ['pizza_id'=>null,'topping_name'=>'Pineapple'],
           
        ];

        DB::table('toppings')->insert($data);
    }
}













