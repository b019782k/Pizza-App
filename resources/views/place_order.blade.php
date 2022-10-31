@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row justify-center">
            <h4>Place Order</h4>
            <br>
        </div>

        <div class="row">

            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        <h4>My Cart</h4>
                    </div>
                    <div class="card-body">
                        @php ($total=0)
                        @foreach($carts as $cart)
                            <div class="cart_product">
                                <h6>{{$cart->pizza_id?$cart->pizza->pizza_name:$cart->pizza_name}} <span
                                        class="float-end">£ {{$cart->price}}</span>
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
                        <a href="{{url('/')}}" class="btn btn-info ">< Go to cart</a>
                    </div>
                </div>


            </div>
            <div class="col-sm-4">
                <form method="post" action="{{url('make_payment')}}">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4>Hello {{$user->name}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Coupon Code</label>
                                <input type="text" name="code" id="code" class="form-control">
                                <p id="code_response" class="text-danger"></p>
                                <br/>
                                <button type="button" class="btn btn-warning" onclick="applyCode()">Apply Code</button>

                            </div>
                            <br/>
                            <hr/>
                            <h6>Net Pay: <span>£{{$total}}</span></h6>
                            <button type="submit" class="btn btn-success btn-lg">Make Payment</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('footerscript')
    <script>
        function applyCode() {
            var code = $("#code").val()
            $.ajax({
                url: "{{url('check_coupon_code')}}",
                type: "get",
                data: {'code': code},
                success: function (response) {
                    $("#code_response").html(response);
                }

            })
        }
    </script>

@endpush
