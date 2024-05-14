@extends('frontend.master')
@section('content')
    <!-- start of themart-interestproduct-section -->
    <section class="themart-interestproduct-section mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="wpo-section-title">
                        <h2>Products Of Your Interest</h2>
                    </div>
                </div>
            </div>
            <div class="product-wrap">
                <div class="row">
                    @forelse ( $products as $product )
                        @php
                            $total_review = App\Models\OrderProduct::where('product_id',$product->id)->whereNotNull('review')->count();
                            $total_star = App\Models\OrderProduct::where('product_id',$product->id)->whereNotNull('review')->sum('star');
                            
                            $avg = '';
                            if($total_review == 0){
                                $avg = 0;
                            }
                            else{
                                $avg = $total_star/$total_review;
                            }
                        @endphp 
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <a href="{{ route('product.single',$product->slug) }}">
                                        <img src="{{ asset('uploads/product/preview') }}/{{ $product->preview }}" alt="">
                                        @if ($product->discount)
                                            <div class="tag sale">-{{ $product->discount }}%</div>
                                        @else
                                            <div class="tag new">New</div>
                                        @endif
                                    </a>
                                </div>
                                <div class="text">
                                    <h2>
                                        @if (strlen($product->product_name) > 20)
                                        <a href="{{ route('product.single',$product->slug) }}" title="{{ $product->product_name }}">{{ Str::substr($product->product_name,0,20).'...' }}</a>
                                        @else
                                        <a href="{{ route('product.single',$product->slug) }}">{{ $product->product_name }}</a>
                                        @endif
                                    </h2>
                                    <div class="rating-product">
                                        @for ($i=1; $i <= $avg; $i++)
                                        <i class="fa fa-star"></i>
                                        @endfor
                                        @for ($i=$avg; $i <= 4; $i++)
                                        <i class="fa fa-star-o"></i>
                                        @endfor
                                        <span>{{ $total_review }}</span>
                                    </div>
                                    <div class="price">
                                        <span class="present-price">&#2547;{{ $product->after_discount }}</span>
                                        @if ($product->discount)
                                            <del class="old-price">&#2547;{{ $product->price }}</del>
                                        @endif
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="{{ route('product.single',$product->slug) }}">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-center para">This product not abable</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
    <!-- end of themart-interestproduct-section -->
@endsection