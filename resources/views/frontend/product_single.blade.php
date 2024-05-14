@extends('frontend.master')
@section('content')
<!-- start wpo-page-title -->
@include('frontend.incrouad.bladecomponet')
<!-- end page-title -->

<!-- product-single-section  start-->
<div class="product-single-section section-padding">
    <div class="container">
        <div class="product-details">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="product-single-img">
                        <div class="product-active owl-carousel">
                            @foreach ( $thumbnails as $thumbnail )
                                <div class="item">
                                    <img src="{{ asset('uploads/product/thumbnail') }}/{{ $thumbnail->thumbnail }}" alt="">
                                </div>
                            @endforeach
                        </div>
                        <div class="product-thumbnil-active  owl-carousel">
                            @foreach ( $thumbnails as $thumbnail )
                                <div class="item">
                                    <img src="{{ asset('uploads/product/thumbnail') }}/{{ $thumbnail->thumbnail }}" alt="">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <form action="{{ route('cart.store') }}" method="post">
                        @csrf
                        <div class="product-single-content">
                            <input type="hidden" name="product_id" value="{{ $product_info->id }}">
                            <h2 class="text-start">{{ $product_info->product_name }}</h2>
                            <div class="price">
                                <span class="present-price">&#2547;{{ $product_info->after_discount }}</span>
                                @if ($product_info->discount)
                                <del class="old-price">&#2547;{{ $product_info->price }}</del>
                                @endif
                            </div>
                            @php
                                $avg ='';
                                if($total_review == 0){
                                    $avg =0;
                                }
                                else{
                                    $avg =round($total_star/$total_review);
                                }
                            @endphp
                            <div class="rating-product">
                                @for ($i=1; $i <= $avg; $i++)
                                    <i class="fa fa-star"></i>
                                @endfor
                                @for ($i=$avg; $i <= 4; $i++)
                                    <i class="fa fa-star-o"></i>
                                @endfor
                                <span>{{ $total_review }}</span>
                            </div>
                            {!! $product_info->short_description !!}
                            <div class="product-filter-item color">
                                <div class="color-name">
                                    <span>Color :</span>
                                    <ul>
                                        @foreach ( $abable_colors as $color )
                                        @if ($color->rel_to_color->color_name == 'NA')
                                        <li title="{{ $color->rel_to_color->color_name }}" class="color1"><input checked
                                                class="color_id" id="color{{ $color->color_id }}" type="radio"
                                                name="color_id" value="{{ $color->color_id }}">
                                            <label
                                                style="background: linear-gradient(180deg, #FED700 0%, #F78914 100%); color: #fff; width:50px; height:40px; border: 2px solid #fff; border-radius: 7px; text-align:center; line-height: 40px;"
                                                for="color{{ $color->color_id }}">{{ $color->rel_to_color->color_name }}</label>
                                        </li>
                                        @else
                                        <li title="{{ $color->rel_to_color->color_name }}" class="color1"><input
                                                class="color_id" id="color{{ $color->color_id }}" type="radio"
                                                name="color_id" value="{{ $color->color_id }}">
                                            <label style="background: {{ $color->rel_to_color->color_code }}"
                                                for="color{{ $color->color_id }}"></label>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="product-filter-item color filter-size">
                                <div class="color-name">
                                    <span>Sizes:</span>
                                    <ul class="sizes">
                                        @foreach ( $abable_sizes as $size )
                                        @if ($size->rel_to_size->size_name == 'NA')
                                        <li class="color"><input checked id="size{{ $size->size_id }}" class="size_id"
                                                type="radio" name="size_id" value="{{ $size->size_id }}">
                                            <label
                                                for="size{{ $size->size_id }}">{{ $size->rel_to_size->size_name }}</label>
                                        </li>
                                        @else
                                        <li class="color"><input id="size{{ $size->size_id }}" class="size_id"
                                                type="radio" name="size_id" value="{{ $size->size_id }}">
                                            <label
                                                for="size{{ $size->size_id }}">{{ $size->rel_to_size->size_name }}</label>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="pro-single-btn">
                                <div class="quantity cart-plus-minus">
                                    <input class="text-value" name="quantity" type="text" value="1">
                                </div>
                                @auth('customer')
                                <button type="submit" name="cart_name" value="1" class="theme-btn-s2 border-0">Add to
                                    cart</button>
                                <button type="submit" class="wl-btn" name="cart_name" value="2"><i
                                        class="fi flaticon-heart"></i></button>
                                @else
                                <a href="{{ route('customer.login') }}" class="theme-btn-s2">Add to cart</a>
                                <a href="{{ route('customer.login') }}" class="wl-btn"><i
                                        class="fi flaticon-heart"></i></a>
                                @endauth
                            </div>
                            <ul class="important-text">
                                <li><span>SKU:</span> {{ $product_info->sku }}</li>
                                <li><span>Categories:</span> {{ $product_info->rel_to_category->category }}</li>
                                @php
                                $after_exploads = explode(',',$product_info->tags)
                                @endphp
                                <li><span>Tags:</span>
                                    @foreach ( $after_exploads as $tag )
                                    <a href="{{ route('tag.product',$tag) }}"><span class="badge bg-warning"
                                            style="padding: 0 10px">{{ App\Models\Tag::find($tag)->tag_name }}</span></a>
                                    @endforeach

                                </li>
                                <li id="quan"></li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="product-tab-area">
            <ul class="nav nav-mb-3 main-tab" id="tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="descripton-tab" data-bs-toggle="pill"
                        data-bs-target="#descripton" type="button" role="tab" aria-controls="descripton"
                        aria-selected="true">Description</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="Ratings-tab" data-bs-toggle="pill" data-bs-target="#Ratings"
                        type="button" role="tab" aria-controls="Ratings" aria-selected="false">Reviews
                        ({{ $total_review }})</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="Information-tab" data-bs-toggle="pill"
                        data-bs-target="#Information" type="button" role="tab" aria-controls="Information"
                        aria-selected="false">Additional info</button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="descripton" role="tabpanel"
                    aria-labelledby="descripton-tab">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="Descriptions-item">
                                    {!! $product_info->long_description !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="Ratings" role="tabpanel" aria-labelledby="Ratings-tab">
                    <div class="container">
                        <div class="rating-section">
                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <div class="comments-area">
                                        <div class="comments-section">
                                            <h3 class="comments-title">{{ $total_review }} reviews for Stylish Pink Coat</h3>
                                            <ol class="comments">
                                                @foreach ( $reviews as $review )
                                                    <li class="comment even thread-even depth-1" id="comment-1">
                                                        <div id="div-comment-1">
                                                            <div class="comment-theme">
                                                                <div class="comment-image">
                                                                    @if ($review->rel_to_customer->photo == null)
                                                                        <img src="{{ Avatar::create($review->rel_to_customer->fname.' '.$review->rel_to_customer->lname)->toBase64() }}" width="70" />
                                                                    @else
                                                                        <img src="{{ asset('uploads/customer') }}/{{ $review->rel_to_customer->photo }}" width="70" alt="">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="comment-main-area">
                                                                <div class="comment-wrapper">
                                                                    <div class="comments-meta">
                                                                        <h4>{{ $review->rel_to_customer->fname.' '.$review->rel_to_customer->lname }}</h4>
                                                                        <span class="comments-date">{{ $review->updated_at->diffForHumans() }}</span>
                                                                        <div class="rating-product">
                                                                            @for ($i=1; $i<=$review->star; $i++)
                                                                            <i class="fa fa-star"></i>
                                                                            @endfor
                                                                            @for ($i=$review->star; $i<=4; $i++)
                                                                            <i class="fa fa-star-o"></i>
                                                                            @endfor
                                                                            {{-- <i class="fi flaticon-star"></i> --}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="comment-area">
                                                                        <p>{{ $review->review }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ol>
                                        </div> <!-- end comments-section -->
                                        @auth('customer')
                                                @if (App\Models\OrderProduct::where('customer_id',Auth::guard('customer')->id())->where('product_id',$product_info->id)->exists())
                                                    @if (App\Models\OrderProduct::where('customer_id',Auth::guard('customer')->id())->where('product_id',$product_info->id)->whereNotNull('review')->first() == false)
                                                        <div class="col col-lg-10 col-12 review-form-wrapper">
                                                            <div class="review-form">
                                                                <h4>Add a review</h4>
                                                                <form action="{{ route('review.store',$product_info->id) }}" method="POST">
                                                                    @csrf
                                                                    <div class="give-rat-sec">
                                                                        <div class="give-rating">
                                                                            <label>
                                                                                <input type="radio" name="stars" value="1" required>
                                                                                <span class="icon">★</span>
                                                                            </label>
                                                                            <label>
                                                                                <input type="radio" name="stars" value="2">
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                            </label>
                                                                            <label>
                                                                                <input type="radio" name="stars" value="3">
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                            </label>
                                                                            <label>
                                                                                <input type="radio" name="stars" value="4">
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                            </label>
                                                                            <label>
                                                                                <input type="radio" name="stars" value="5">
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                            </label>
                                                                        </div>
                                                                        @error('stars')
                                                                            <strong class="text-danger">{{ $message }}</strong>
                                                                        @enderror
                                                                    </div>
                                                                    <div>
                                                                        <textarea class="form-control" name="review"
                                                                            placeholder="Write Comment..." required></textarea>
                                                                            @error('review')
                                                                                <strong class="text-danger">{{ $message }}</strong>
                                                                            @enderror
                                                                    </div>
                                                                    <div class="name-input">
                                                                        <input type="text" class="form-control" placeholder="Name"
                                                                            value="{{ Auth::guard('customer')->user()->fname }} {{ Auth::guard('customer')->user()->lname }}" disabled>
                                                                    </div>
                                                                    <div class="name-email">
                                                                        <input type="email" class="form-control" placeholder="Email"
                                                                        value="{{ Auth::guard('customer')->user()->email }}" disabled>
                                                                    </div>
                                                                    <div class="rating-wrapper">
                                                                        <div class="submit">
                                                                            <button type="submit" class="theme-btn-s2">Post
                                                                                review</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @else
                                                    <div class="alert alert-info">
                                                        <p>You are already review this product</p>
                                                    </div>
                                                @endif
                                                    @else
                                                    <div class="alert alert-info">
                                                        <p>You did not perces this product</p>
                                                    </div>
                                                @endif
                                            @else
                                            <div class="alert alert-info d-flex justify-content-between">
                                                <p>You did not login</p>
                                                <a href="{{ route('customer.login') }}" class="btn btn-primary">Login Now</a>
                                            </div>
                                        @endauth
                                    </div> <!-- end comments-area -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="Information" role="tabpanel" aria-labelledby="Information-tab">
                    <div class="container">
                        <div class="Additional-wrap">
                            <div class="row">
                                <div class="col-12">
                                    {!! $product_info->additional_information !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="related-product">
    </div>
</div>
<!-- product-single-section  end-->
    <!-- start of themart-relatedproduct-section -->
<section class="themart-trendingproduct-section section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="wpo-section-title">
                    <h2>Related Products</h2>
                </div>
            </div>
        </div>
        <div class="{{ $related_products->count() >=4 ? 'trendin-slider owl-carousel':'row'  }}">
            @forelse ( $related_products as $product )
            <div class="{{ $related_products->count() < 4 ? 'col-lg-4':'' }}">
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
                            <a href="{{ route('product.single',$product->slug) }}"
                                title="{{ $product->product_name }}">{{ Str::substr($product->product_name,0,20).'...' }}</a>
                            @else
                            <a href="{{ route('product.single',$product->slug) }}">{{ $product->product_name }}</a>
                            @endif
                        </h2>
                        <div class="rating-product">
                            <i class="fi flaticon-star"></i>
                            <i class="fi flaticon-star"></i>
                            <i class="fi flaticon-star"></i>
                            <i class="fi flaticon-star"></i>
                            <i class="fi flaticon-star"></i>
                            <span>130</span>
                        </div>
                        <div class="price">
                            <span class="present-price">&#2547; {{ $product->after_discount }}</span>
                            @if ($product->discount)
                            <del class="old-price">&#2547; {{ $product->price }}</del>
                            @endif
                        </div>
                        <div class="shop-btn">
                            <a class="theme-btn-s2" href="{{ route('product.single',$product->slug) }}">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <h4 class="text-center">[No related product found]</h4>
            @endforelse
        </div>
    </div>
</section>
<!-- end of themart-relatedproduct-section -->
@endsection
@section('footer_script')
    <script>
        $('.color_id').click(function () {
            var color_id = $(this).val();
            var product_id = '{{ $product_info->id }}';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: '/getsize',
                data: {
                    'color_id': color_id,
                    'product_id': product_id
                },
                success: function (data) {
                    $('.sizes').html(data);
                    $('.size_id').click(function () {
                        var size_id = $(this).val();
                        $.ajax({
                            type: 'POST',
                            url: '/getquantity',
                            data: {
                                'color_id': color_id,
                                'product_id': product_id,
                                'size_id': size_id
                            },
                            success: function (data) {
                                $('#quan').html(data);
                            }
                        });
                    })
                }
            });
        })
    </script>
@if (session('success'))
<script>
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 1500
    });

</script>
@endif
@endsection