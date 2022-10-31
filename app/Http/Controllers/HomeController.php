<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Pizza;
use App\Models\Topping;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $pizzas = Pizza::all();
        $toppings = Topping::all();
        $carts = Cart::with(['pizza','cartDetails'])->where('session_id', session('session_id'))->get();
        return view('home', compact('pizzas', 'carts', 'toppings'));
    }

    public function addToCart(Request $request)
    {
         $request->validate([
            'pizza_id'=>'required|integer',
            'selected_size'=>'required',
         ]);
         if(!session('session_id')){
             session(['session_id' => rand(99999, 999999)]);
         }

        $pizza = Pizza::find($request->pizza_id);
        $price = 0;
        $toping_price = 0;
        if($request->selected_size == "small"){
            $price = $pizza->small_price;
            $toping_price = 0.90;
        }
        elseif($request->selected_size == "medium"){
            $price = $pizza->medium_price;
            $toping_price = 1.00;
        }
        elseif($request->selected_size == "large"){
            $price = $pizza->large_price;
            $toping_price = 1.15;
        }

        $store = new Cart();
        $store->session_id = session('session_id');
        $store->pizza_id = $request->pizza_id;
        $store->size = $request->selected_size;
        $store->price = $price;
        $store->save();

        $toppings = $request->toppings;
        if($toppings){
            foreach ($toppings as $key => $value) {

                $data2 = new CartDetail();
                $data2->cart_id = $store->id;
                $data2->topping_id = $toppings[$key];
                $data2->price = $toping_price;
                $data2->save();
            }
        }

        return redirect()->back();
    }

    public function ownPizza(Request $request)
    {
         $request->validate([
            'own_size'=>'required',
         ]);
         if(!session('session_id')){
             session(['session_id' => rand(99999, 999999)]);
         }

        $pizza = Pizza::find($request->pizza_id);
        $price = 0;
        $toping_price = 0;
        if($request->own_size == "small"){
            $toping_price = 0.90;
            $price=8;
        }
        elseif($request->own_size == "medium"){
            $toping_price = 1.00;
            $price=9;
        }
        elseif($request->own_size == "large"){
            $toping_price = 1.15;
            $price=11;
        }

        $store = new Cart();
        $store->session_id = session('session_id');
        $store->pizza_name = "Creat Own pizza";
        $store->size = $request->own_size;
        $store->price = $price;
        $store->save();

        $toppings = $request->toppings;
        if($toppings){
            foreach ($toppings as $key => $value) {

                $data2 = new CartDetail();
                $data2->cart_id = $store->id;
                $data2->topping_id = $toppings[$key];
                $data2->price = $toping_price;
                $data2->save();
            }
        }

        return redirect()->back();
    }
}
