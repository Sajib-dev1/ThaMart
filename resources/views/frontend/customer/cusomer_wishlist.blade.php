@extends('frontend.master')
@section('title')
    Customer Wishlist
@endsection
@section('content')
<!-- start wpo-page-title -->
@include('frontend.incrouad.bladecomponet')
<!-- end page-title -->

<div class="container">
    <div class="row my-5">
        @include('frontend.incrouad.profile_sidebar')
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header p-2 customer">
                    <h3>My wishlist</h3>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="profile_list">
                        <table class="table table-borderd">
                            <tr>
                                <th>SL</th>
                                <th>product Name</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            @foreach ( $wishlists as $sl=>$wishlist )  
                                <tr>
                                    <td>{{ $sl+1 }}</td>
                                    <td>
                                        @if (strlen($wishlist->rel_to_product->product_name)>25)
                                        <li class="first-cart" title="{{ $wishlist->rel_to_product->product_name }}">{{ Str::substr($wishlist->rel_to_product->product_name,0,25).'..' }}</li>
                                        @else
                                        <li class="first-cart">{{ $wishlist->rel_to_product->product_name }}</li>
                                        @endif
                                    </td>
                                    <td>&#2547;{{ $wishlist->rel_to_product->after_discount }}</td>
                                    <td class="stock">
                                        @php
                                            if(App\Models\Inventory::where('product_id',$wishlist->product_id)->exists()){
                                                echo '<span class="in-stock badge bg-success">In Stock</span>';
                                            }
                                            else{
                                                echo '<span class="in-stock out-stock badge bg-warning">Out Stock</span>';
                                            }
                                        @endphp
                                    </td>
                                    <td>
                                        <a href="{{ route('wishlist.remove',$wishlist->id) }}" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>     
@endsection