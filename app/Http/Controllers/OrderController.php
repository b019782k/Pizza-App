<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function placeOrder(){
        $user = Auth::user();
        $carts = Cart::with(['pizza','cartDetails'])->where('session_id', session('session_id'))->get();
        return view('place_order', compact('carts','user'));
    }

    public function checkCouponCode(Request $request){
        $code = $request->code;
        $sessionId = session('session_id');
        if($code == "BOGOF"){
            $count = Cart::where('session_id', $sessionId)->where('size','medium')->count();
            if($count == 2){
                $maxPrice = Cart::where('session_id', $sessionId)->where('size','medium')->max('price');
                return response()->json("Code applied, you get 2 medium pizza in <b>$maxPrice</b>");
            }
            $count = Cart::where('session_id', $sessionId)->where('size','large')->count();
            if($count == 2){
                $maxPrice = Cart::where('session_id', $sessionId)->where('size','large')->max('price');
                return response()->json("Code applied, you get 2 large pizza in <b>$maxPrice</b>");
            }
            return response()->json("Coupon not applied on your order");
        }
        elseif($code == "Three for Two"){
            $count = Cart::where('session_id', $sessionId)->where('size','medium')->count();
            if($count ==  3){
                $maxPrice = Cart::where('session_id', $sessionId)->where('size','medium')->orderBy('price','desc')->take(2)->get()->sum('price');
                return response()->json("Code applied, you get 3 medium pizza in <b>$maxPrice</b>");
            }
            return response()->json("Coupon not applied on your order");
        }
        elseif($code == "Family Feast"){
            $count = Cart::where('session_id', $sessionId)->where('size','medium')->whereNotNull('pizza_id')->count();
            dd($count);
            if($count ==  4){
                return response()->json("Code applied, you get 4 medium pizza in <b>£30</b>");
            }
            return response()->json("Coupon not applied on your order");
        }
        elseif($code == "Two Large"){
            $count = Cart::where('session_id', $sessionId)->where('size','large')->whereNotNull('pizza_id')->count();
            if($count ==  2){
                return response()->json("Code applied, you get 2 large pizza in <b>£25</b>");
            }
            return response()->json("Coupon not applied on your order");
        }
        elseif($code == "Two Medium"){
            $count = Cart::where('session_id', $sessionId)->where('size','medium')->whereNotNull('pizza_id')->count();
            if($count ==  2){
                return response()->json("Code applied, you get 2 medium pizza in <b>£18</b>");
            }
            return response()->json("Coupon not applied on your order");
        }
        elseif($code == "Two Small"){
            $count = Cart::where('session_id', $sessionId)->where('size','small')->whereNotNull('pizza_id')->count();
            if($count ==  2){
                return response()->json("Code applied, you get 2 small pizza in <b>£12</b>");
            }
            return response()->json("Coupon not applied on your order");
        }
        return response()->json("Invalid coupon code");
    }

    public function makePayment(Request $request){
        $sessionId = session('session_id');
        $carts = Cart::with(['pizza','cartDetails'])->where('session_id', session('session_id'))->get();
        $total_price = 0;

        //in order table
        $order = new Order();
        $order->user_id = Auth::id();
        $order->coupon_code = $request->code;
        $order->total_price = $total_price;
        $order->save();

        $total_price = 0;
        foreach ($carts as $cart){
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $order->id;
            $orderDetail->pizza_id = $cart->pizza_id;
            $orderDetail->pizza_name = $cart->pizza_name;
            $orderDetail->size = $cart->size;
            $orderDetail->price = $cart->price;
            $topping = '';
            $total_price += $cart->price;;
            foreach ($cart->cartDetails as $detail){
                $topping .=$detail->topping->topping_name." - €".$detail->price;
                $total_price += $detail->price;;
            }
            $orderDetail->toppings = $topping;
            $orderDetail->save();
        }
        $order->total_price = $total_price;
        //Delete from cart
        Cart::where('session_id', session('session_id'))->delete();
        return redirect('my_orders');

    }



    public function myOrders(){
        $userId = Auth::id();
        $orders = Order::with('orderDetail')->where('user_id', $userId)->get();
        return view('my_orders', compact('orders'));
    }
}
