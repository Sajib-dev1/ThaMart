@extends('frontend.master')
@section('content')
<!-- start wpo-page-title -->
@include('frontend.incrouad.bladecomponet')
<!-- end page-title -->

<!-- wpo-checkout-area start-->
<div class="wpo-checkout-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="single-page-title">
                    <h2>Your Checkout</h2>
                    <p>There are {{ $carts->count() }} products in this list</p>
                </div>
            </div>
        </div>
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="checkout-wrap">
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <div class="caupon-wrap s3">
                            <div class="biling-item">
                                <div class="coupon coupon-3">
                                    <h2>Billing Address</h2>
                                </div>
                                <div class="billing-adress">
                                    <div class="contact-form form-style">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="text" placeholder="First Name*" id="fname1" name="fname" value="{{ Auth::guard('customer')->user()->fname }}">
                                                @error('fname')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="text" placeholder="Last Name*" id="fname2" name="lname" value="{{ Auth::guard('customer')->user()->lname }}">
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <select name="country" id="Country" class="form-control country">
                                                    <option>Country*</option>
                                                    @foreach ( $countries as $country )
                                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('country')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <select name="city" id="City" class="form-control city">
                                                    <option>City*</option>
                                                </select>
                                                @error('city')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="text" placeholder="Postcode / ZIP*" id="Post2" name="zip" value="{{ Auth::guard('customer')->user()->zip }}">
                                                @error('zip')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="text" placeholder="Company Name*" id="Company" name="company">
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="email" placeholder="Email Address*" id="email4" name="email" value="{{ Auth::guard('customer')->user()->email }}">
                                                @error('email')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="phone" placeholder="Phone*" id="phone2" name="phone" value="{{ Auth::guard('customer')->user()->phone }}">
                                                @error('phone')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-12">
                                                <input type="text" placeholder="Address*" id="Adress" name="address">
                                                @error('address')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-12">
                                                <div class="note-area">
                                                    <textarea name="notes" placeholder="Additional Information"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="biling-item-3">
                                    <input id="toggle4" type="checkbox" name="ship_check" value="1">
                                    <label class="fontsize" for="toggle4">Ship to a Different Address?</label>
                                    <div class="billing-adress" id="open4">
                                        <div class="contact-form form-style">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="text" placeholder="First Name*" id="fname6" name="ship_fname">
                                                    @error('ship_fname')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="text" placeholder="Last Name*" id="fname7" name="ship_lname">
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <select name="ship_country" id="Country2" class="form-control country2" style="width: 100%">
                                                        <option value="">Country*</option>
                                                        @foreach ( $countries as $country )
                                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('ship_country')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <select name="ship_city" id="City2" class="form-control city2" style="width: 100%">
                                                        <option value="">City*</option>
                                                    </select>
                                                    @error('ship_city')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="text" placeholder="Postcode / ZIP*" id="Post1" name="ship_zip">
                                                    @error('ship_zip')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="text" placeholder="Company Name*" id="Company1" name="ship_company">
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="email" placeholder="Email Address*" id="email5" name="ship_email">
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="text" placeholder="Phone*" id="phone1" name="ship_phone">
                                                    @error('ship_phone')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-12">
                                                    <input type="text" placeholder="Address*" id="Adress1" name="ship_address">
                                                    @error('ship_address')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="cout-order-area">
                            <h3>Your Order</h3>
                            <div class="oreder-item">
                                <div class="title">
                                    <h2>Products <span>Subtotal</span></h2>
                                </div>
                                @foreach ( $carts as $cart )
                                    @php
                                        $total_review = App\Models\OrderProduct::where('product_id',$cart->product_id)->whereNotNull('review')->count();
                                        $total_star = App\Models\OrderProduct::where('product_id',$cart->product_id)->whereNotNull('review')->sum('star');
                                        
                                        $avg = '';
                                        if($total_review == 0){
                                            $avg = 0;
                                        }
                                        else{
                                            $avg = $total_star/$total_review;
                                        }
                                    @endphp 
                                    <div class="oreder-product">
                                        <div class="images">
                                            <span>
                                                <img src="{{ asset('uploads/product/preview') }}/{{ $cart->rel_to_product->preview }}" alt="">
                                            </span>
                                        </div>
                                        <div class="product">
                                            <ul>
                                                <li class="first-cart">
                                                    @if (strlen($cart->rel_to_product->product_name)>12)
                                                        {{ Str::substr($cart->rel_to_product->preview,0,12).'..' }}
                                                    @else
                                                        {{ $cart->rel_to_product->product_name }}
                                                    @endif
                                                    (x{{  $cart->quantity }})

                                                </li>
                                                <li>
                                                    <div class="rating-product">
                                                        @for ($i=1; $i <= $avg; $i++)
                                                        <i class="fa fa-star"></i>
                                                        @endfor
                                                        @for ($i=$avg; $i <= 4; $i++)
                                                        <i class="fa fa-star-o"></i>
                                                        @endfor
                                                        <span>{{ $total_review }}</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <span>&#2547;{{ $cart->rel_to_product->after_discount*$cart->quantity }}</span>
                                    </div>
                                @endforeach
                                <!-- Shipping -->
                                <div class="mt-3 mb-3">
                                    <div class="title border-0">
                                        <h2>Delivery Charge</h2>
                                    </div>
                                    <ul>
                                        <li class="free">
                                            <input id="Free" data-total="{{ session('total') }}" type="radio" name="charge" class="delivery" value="1">
                                            <label for="Free">Inside City: <span>&#2547;{{ $delivery_inside }}</span></label>
                                        </li>
                                        <li class="free">
                                            <input id="Local" data-total="{{ session('total') }}" type="radio" name="charge" class="delivery" value="2">
                                            <label for="Local">Outside City: <span>&#2547;{{ $delivery_outside }}</span></label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="title s2">
                                    <h2>Total<span> &#2547;<span id="finel_total">{{ session('total') }}</span></span></h2>
                                </div>
                            </div>
                        </div>
                        <div class="caupon-wrap s5">
                            <div class="payment-area">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="payment-option" id="open5">
                                            <h3>Payment</h3>
                                            <div class="payment-select">
                                                <ul>
                                                    <li class="">
                                                        <input id="remove" type="radio" name="payment_method" value="1">
                                                        <label for="remove">Cash on Delivery</label>
                                                    </li>
                                                    <li class="">
                                                        <input id="add" type="radio" name="payment_method" checked="checked" value="2">
                                                        <label for="add">Pay With SSLCOMMERZ</label>
                                                    </li>
                                                    <li class="">
                                                        <input id="getway" type="radio" name="payment_method" value="3">
                                                        <label for="getway">Pay With STRIPE</label>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div id="open6" class="payment-name active">
                                                <div class="contact-form form-style">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-12">
                                                            <div class="submit-btn-area text-center">
                                                                <button class="theme-btn" type="submit">Place Order</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="customer_id" value="{{ Auth::guard('customer')->id() }}">
                                            <input type="hidden" name="discount" value="{{ session('discount') }}">
                                            <input type="hidden" name="sub_total" value="{{ session('total')+session('discount') }}">
                                            <input type="hidden" name="total" value="{{ session('total') }}">
                                            <input type="hidden" name="coupon_id" value="{{ session('coupon_id') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- wpo-checkout-area end-->
@endsection
@section('footer_script')
    <script>
        $('.delivery').click(function(){
            var inside = '{{ $delivery_inside }}';
            var outside = '{{ $delivery_outside }}';

            var delivery = $(this).val();
            var total = $(this).attr('data-total');

            if(delivery == 1){
                finel_total = parseInt(total)+parseInt(inside);
            }
            else{
                finel_total = parseInt(total)+parseInt(outside);
            }
            $('#finel_total').html(finel_total)
        })
    </script>
        <script>
            $('.country').change(function(){
                var country_id = $(this).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
    
                $.ajax({
                    type: "POST",
                    url: '/getcheckoutcity',
                    data: { 'country_id':country_id },
                    success: function( data ) {
                        $('.city').html(data)
                    }
                });
            });
        </script>
        <script>
            $('.country2').change(function(){
                var country_id = $(this).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
    
                $.ajax({
                    type: "POST",
                    url: '/getcheckoutcity',
                    data: { 'country_id':country_id },
                    success: function( data ) {
                        $('.city2').html(data)
                    }
                });
            });
        </script>
@endsection