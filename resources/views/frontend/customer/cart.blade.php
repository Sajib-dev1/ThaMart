@extends('frontend.master')
@section('content')
@include('frontend.incrouad.bladecomponet')
<!-- end page-title -->
 <!-- cart-area-s2 start -->
 <div class="cart-area-s2 section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="single-page-title">
                    <h2>Your Cart</h2>
                    <p>There are {{ $carts->count() }} products in this list</p>
                </div>
            </div>
        </div>
        <div class="cart-wrapper">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <form action="{{ route('cart.update') }}" method="POST">
                        @csrf
                        <div class="cart-item">
                            <table class="table-responsive cart-wrap">
                                <thead>
                                    <tr>
                                        <th class="images images-b">Product</th>
                                        <th class="ptice">Price</th>
                                        <th class="stock">Quantity</th>
                                        <th class="ptice total">Subtotal</th>
                                        <th class="remove remove-b">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sub_total = 0;
                                    @endphp
                                    @forelse ( $carts as $cart )
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
                                        <tr class="wishlist-item">
                                            <td class="product-item-wish">
                                                <div class="check-box"><input type="checkbox"
                                                        class="myproject-checkbox">
                                                </div>
                                                <div class="images">
                                                    <span>
                                                        <img src="{{ asset('uploads/product/preview') }}/{{ $cart->rel_to_product->preview }}" alt="">
                                                    </span>
                                                </div>
                                                <div class="product">
                                                    <ul>
                                                        @if (strlen($cart->rel_to_product->product_name)>12)
                                                            <li class="first-cart" title="{{ $cart->rel_to_product->product_name }}">{{ Str::substr($cart->rel_to_product->product_name,0,12).'..' }}</li>
                                                        @else
                                                            <li class="first-cart">{{ $cart->rel_to_product->product_name }}</li>
                                                        @endif
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
                                            </td>
                                            <td class="ptice">&#2547;{{ $cart->rel_to_product->after_discount }}</td>
                                            <td class="td-quantity">
                                                <div class="quantity cart-plus-minus">
                                                    <input class="text-value" type="text" name="quantity[{{ $cart->id }}]" value="{{ $cart->quantity }}">
                                                    <div class="dec qtybutton">-</div>
                                                    <div class="inc qtybutton">+</div>
                                                </div>
                                            </td>
                                            <td class="ptice">&#2547;{{ $cart->rel_to_product->after_discount*$cart->quantity }}</td>
                                            <td class="action">
                                                <ul>
                                                    <li class="w-btn"><a data-bs-toggle="tooltip"
                                                            data-bs-html="true" title="" href="{{ route('cart.remove',$cart->id) }}"
                                                            data-bs-original-title="Remove from Cart"
                                                            aria-label="Remove from Cart"><i
                                                                class="fi ti-trash"></i></a></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        @php
                                            $sub_total = $sub_total += $cart->rel_to_product->after_discount*$cart->quantity;
                                        @endphp
                                       @empty
                                       <tr>
                                            <td class="colspan-4">
                                                <div class="alert alert-success text-center">Cart Empty</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                        <div class="cart-action">
                            <button type="submit" class="theme-btn-s2 border-0"><i class="fi flaticon-refresh"></i> Update Cart</button>
                        </div>
                    </form>
                </div>
                @php
                    $finel_discount = 0;
                    $total = 0;
                    $coupon_id = 0;
                        if($type == 1){
                            $finel_discount = round($sub_total*$amount/100);
                            $total = $sub_total-$finel_discount;
                            $coupon_id = 1;
                        }
                        else{
                            $finel_discount = $amount;
                            $total = $sub_total-$finel_discount;
                            $coupon_id = 2;
                        }

                    session([
                            'discount'=>$finel_discount,
                            'total'=>$total,
                            'coupon_id'=>$coupon_id,
                        ])
                @endphp
                <div class="col-lg-4 col-12">
                    <div class="mb-2">
                        <form action="{{ route('cart') }}" method="Get">
                            <div class="apply-area">
                                <input type="text" class="form-control" name="coupon" placeholder="Enter your coupon">
                                <button class="theme-btn-s2" type="submit">Apply</button>
                            </div>
                        </form>
                        <div class="div mt-2">
                            @if ($message)
                            <div class="alert alert-danger" style="padding: 5px 20px">{{ $message }}</div>
                        @endif
                        </div>
                    </div>
                    <div class="cart-total-wrap">
                        <h3>Cart Totals</h3>
                        <div class="sub-total">
                            <h4>Subtotal</h4>
                            <span>&#2547;{{ $sub_total }}</span>
                        </div>
                        <div class="sub-total my-3">
                            <h4>Discount</h4>
                            <span>&#2547;{{ $finel_discount }}</span>
                        </div>
                        <div class="total mb-3">
                            <h4>Total</h4>
                            <span>&#2547;{{ $total }}</span>
                        </div>
                        <a class="theme-btn-s2" href="{{ route('checkout') }}">Proceed To CheckOut</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="cart-prodact">
            <h2>You May be Interested in…</h2>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="product-item">
                        <div class="image">
                            <img src="assets/images/interest-product/1.png" alt="">
                            <div class="tag new">New</div>
                        </div>
                        <div class="text">
                            <h2><a href="product-single.html">Wireless Headphones</a></h2>
                            <div class="rating-product">
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <span>130</span>
                            </div>
                            <div class="price">
                                <span class="present-price">$120.00</span>
                                <del class="old-price">$200.00</del>
                            </div>
                            <div class="shop-btn">
                                <a class="theme-btn-s2" href="product.html">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="product-item">
                        <div class="image">
                            <img src="assets/images/interest-product/2.png" alt="">
                            <div class="tag sale">Sale</div>
                        </div>
                        <div class="text">
                            <h2><a href="product-single.html">Blue Bag with Lock</a></h2>
                            <div class="rating-product">
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <span>120</span>
                            </div>
                            <div class="price">
                                <span class="present-price">$160.00</span>
                                <del class="old-price">$190.00</del>
                            </div>
                            <div class="shop-btn">
                                <a class="theme-btn-s2" href="product.html">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="product-item">
                        <div class="image">
                            <img src="assets/images/interest-product/3.png" alt="">
                            <div class="tag new">New</div>
                        </div>
                        <div class="text">
                            <h2><a href="product-single.html">Stylish Pink Top</a></h2>
                            <div class="rating-product">
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <span>150</span>
                            </div>
                            <div class="price">
                                <span class="present-price">$150.00</span>
                                <del class="old-price">$200.00</del>
                            </div>
                            <div class="shop-btn">
                                <a class="theme-btn-s2" href="product.html">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="product-item">
                        <div class="image">
                            <img src="assets/images/interest-product/4.png" alt="">
                            <div class="tag sale">Sale</div>
                        </div>
                        <div class="text">
                            <h2><a href="product-single.html">Brown Com Boots</a></h2>
                            <div class="rating-product">
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <span>120</span>
                            </div>
                            <div class="price">
                                <span class="present-price">$120.00</span>
                                <del class="old-price">$150.00</del>
                            </div>
                            <div class="shop-btn">
                                <a class="theme-btn-s2" href="product.html">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- cart-area end -->
<!-- cart-area end -->    
@endsection