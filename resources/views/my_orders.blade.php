@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row justify-center">
            <h4>My Orders</h4>
            <br>
        </div>
        <div class="row">

            <div class="col-sm-8">


                        @foreach($orders as $order)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h4>Order ID: {{$order->id}} <span class="float-end"> {{date('d-m-Y', strtotime($order->created_at))}}</span>
                                    </h4>
                                </div>
                                <div class="card-body">
                            <div class="cart_product">
                                <ul>
                                    @foreach($order->orderDetail as $detail)
                                        <li>{{$detail->pizza_id?$detail->pizza->pizza_name:$detail->pizza_name}} <span
                                                class="float-end">£ {{$detail->price}}</span>
                                            <br />
                                            Toppings:{{$detail->toppings}}
                                        </li>
                                    @endforeach
                                </ul>
                                <h6>Total: <span class="float-end">£ {{$order->total_price}}</span></h6>
                            </div>

                            </div>
                            </div>

                        @endforeach

            </div>
            </div>

    </div>
@endsection

