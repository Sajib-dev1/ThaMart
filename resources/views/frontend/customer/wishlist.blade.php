@extends('frontend.master')
@section('content')
<!-- start wpo-page-title -->
@include('frontend.incrouad.bladecomponet')
<!-- end page-title -->

<div class="cart-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="single-page-title">
                    <h2>Your Wishlist</h2>
                    <p>There are {{ $wishlists->count() }} products in this list</p>
                </div>
            </div>
        </div>
        <div class="form">
            <div class="cart-wrapper">
                <div class="row">
                    <div class="col-12">
                        <form action="https://wpocean.com/html/tf/themart/cart">
                            <table class="table-responsive cart-wrap">
                                <thead>
                                    <tr>
                                        <th class="images images-b">Product</th>
                                        <th class="ptice">Price</th>
                                        <th class="stock">Stock Status</th>
                                        <th class="remove remove-b">Action</th>
                                        <th class="remove remove-b">Remove</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach ( $wishlists as $wishlist )
                                    @php
                                        $total_review = App\Models\OrderProduct::where('product_id',$wishlist->product_id)->whereNotNull('review')->count();
                                        $total_star = App\Models\OrderProduct::where('product_id',$wishlist->product_id)->whereNotNull('review')->sum('star');
                                        
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
                                                        <img src="{{ asset('uploads/product/preview') }}/{{ $wishlist->rel_to_product->preview }}" alt="">
                                                    </span>
                                                </div>
                                                <div class="product">
                                                    <ul>
                                                        @if (strlen($wishlist->rel_to_product->product_name)>25)
                                                        <li class="first-cart" title="{{ $wishlist->rel_to_product->product_name }}">{{ Str::substr($wishlist->rel_to_product->product_name,0,25).'..' }}</li>
                                                        @else
                                                        <li class="first-cart">{{ $wishlist->rel_to_product->product_name }}</li>
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
                                            <td class="ptice">&#2547;{{ $wishlist->rel_to_product->after_discount }}</td>
                                            <td class="stock">
                                                @php
                                                    if(App\Models\Inventory::where('product_id',$wishlist->product_id)->exists()){
                                                        echo '<span class="in-stock">In Stock</span>';
                                                    }
                                                    else{
                                                        echo '<span class="in-stock out-stock">Out Stock</span>';
                                                    }
                                                @endphp
                                            </td>
                                            <td class="add-wish">
                                                <a class="theme-btn-s2" href="{{ route('product.single',$wishlist->rel_to_product->slug) }}">Shop Now</a>
                                            </td>
                                            <td class="action">
                                                <ul>
                                                    <li class="w-btn"><a data-bs-toggle="tooltip"
                                                            data-bs-html="true" title="" href="{{ route('wishlist.remove',$wishlist->id) }}"
                                                            data-bs-original-title="Remove"
                                                            aria-label="Remove"><i
                                                                class="fi flaticon-remove"></i></a></li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody> 
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection