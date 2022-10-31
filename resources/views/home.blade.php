@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row justify-center">
            <h4>Menu</h4>
            <br>
        </div>
        <div class="row ">

            @csrf
            <div class="row">
                <div class="col-sm-8">
                    <p class="text-danger">{{$errors->first()}}</p>
                    @foreach($pizzas as $pizza)
                        <div class="card mb-4">
                            <form method="POST" action="{{route('addTocart')}}" id="addToCart">
                                @csrf
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <h6> {{ $pizza->pizza_name }} (£ <span
                                                    id="pizza_price{{$pizza->id}}">0</span>)</h6>
                                            <input type="hidden" name="pizza_id" value="{{$pizza->id}}"
                                                   id="pizza_id{{$pizza->id}}" required>
                                            <input type="hidden" name="selected_size" id="selected_size{{$pizza->id}}"
                                                   required>
                                        </div>
                                        <div class="col-sm-3">
                                            <select class="form-select" id="size{{$pizza->id}}" name="pizza_size"
                                                    required>
                                                <option value="">Select Size</option>
                                                <option value="small/{{$pizza->small_price}}">Small</option>
                                                <option value="medium/{{$pizza->medium_price}}">Medium</option>
                                                <option value="large/{{$pizza->large_price}}">Large</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-10">
                                            <h6> Topping Price (£ <span id="toppingPrice1" class="toppingPrice"></span>
                                                )</h6>
                                            @foreach ($pizza->toppings as $topping)
                                                <input class="form-check-input" name="toppings[]" type="checkbox"
                                                       value="{{$topping->id}}" id="topping{{$topping->id}}"
                                                       onclick="topping({{$topping->id}}, {{$pizza->id}})">
                                                <label class="form-check-label" for="toppingID{{$topping->id}}">
                                                    {{ $topping->topping_name }} (£ <span
                                                        class="top_text{{$pizza->id}}">0</span>)
                                                </label>
                                                &nbsp;&nbsp;&nbsp;
                                            @endforeach
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="submit" class="btn btn-primary submit-btn1">Add to Cart
                                            </button>
                                        </div>


                                    </div>
                                </div>
                            </form>
                        </div>
                    @endforeach

{{--                    Create own pizza--}}
                    <div class="card mb-4">
                        <form method="POST" action="{{route('own_pizza')}}" >
                            @csrf
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <h6> Create Own Pizza</h6>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-select" id="own_size" name="own_size"
                                                required>
                                            <option value="">Select Size</option>
                                            <option value="small">Small</option>
                                            <option value="medium">Medium</option>
                                            <option value="large">Large</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-10">
                                        <h6> Topping Price (£ <span id="toppingPrice1" class="toppingPrice"></span>
                                            )</h6>
                                        @foreach ($toppings as $topping)
                                            <input class="form-check-input" name="toppings[]" type="checkbox"
                                                   value="{{$topping->id}}" id="owntopping{{$topping->id}}"
                                                   onclick="topping({{$topping->id}}, {{$pizza->id}})">
                                            <label class="form-check-label" for="owntoppingID{{$topping->id}}">
                                                {{ $topping->topping_name }} (£ <span
                                                    class="own_top_text">0</span>)
                                            </label>
                                            &nbsp;&nbsp;&nbsp;<br >
                                        @endforeach
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="submit" class="btn btn-primary submit-btn1">Add to Cart
                                        </button>
                                    </div>


                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>My Cart</h4>
                        </div>
                        <div class="card-body">
                            @php ($total=0)
                            @foreach($carts as $cart)
                                <div class="cart_product">
                                    <h6>{{$cart->pizza_id?$cart->pizza->pizza_name:$cart->pizza_name}} - {{$cart->size}} <span class="float-end">£ {{$cart->price}}</span>
                                        @php ($total += $cart->price)
                                    </h6>
                                    <ul>
                                        @foreach($cart->cartDetails as $detail)
                                            <li>{{$detail->topping->topping_name}} <span
                                                    class="float-end">£ {{$detail->price}}</span></li>
                                            @php ($total += $detail->price)
                                        @endforeach
                                    </ul>
                                </div>

                            @endforeach
<h6>Total: <span class="float-end">£ {{$total}}</span></h6>
                            <br />
                            <a href="{{url('place_order')}}" class="btn btn-success btn-lg">Place Order</a>
                        </div>
                    </div>


                </div>
            </div>

        </div>
        @endsection
        @push('footerscript')
            <script>
//Common pizza script
                $("[id^=size]").on('change', function () {
                    var productId = $(this).attr('id').slice(-1);
                    var sizeValue = $(this).val()
                    var splitValue = sizeValue.split("/");
                    var size = splitValue[0];
                    $("#pizza_price" + productId).text(splitValue[1])
                    $("#selected_size" + productId).val(size)

                    var tp_price = 0;
                    if (size == "small") {
                        tp_price = 0.90
                    } else if (size == "medium") {
                        tp_price = 1.00
                    } else if (size == "large") {
                        tp_price = 1.15
                    }
                    $('.top_text' + productId).text(tp_price)
                })


                // Own pizza script
                $("#own_size").on('change', function () {
                    var size = $(this).val()

                    var tp_price = 0;
                    if (size == "small") {
                        tp_price = 0.90
                    } else if (size == "medium") {
                        tp_price = 1.00
                    } else if (size == "large") {
                        tp_price = 1.15
                    }
                    $('.own_top_text').text(tp_price)
                })

            </script>
    @endpush
