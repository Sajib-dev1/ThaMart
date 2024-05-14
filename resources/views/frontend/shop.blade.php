@extends('frontend.master')
@section('content')
<!-- start wpo-page-title -->
@include('frontend.incrouad.bladecomponet')
<!-- end page-title -->

    <!-- product-area-start -->
    <div class="shop-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="shop-filter-wrap">
                        <div class="filter-item">
                            <div class="shop-filter-item">
                                <div class="shop-filter-search">
                                    <form>
                                        <div>
                                            <input type="text" id="search_input2" value="{{ @$_GET['search_input'] }}" class="form-control" placeholder="Search..">
                                            <button class="search_btn2" type="button"><i class="ti-search"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="shop-filter-item">
                                <h2>Filter By Category</h2>
                                <ul>
                                    @foreach ( $categories as $category )
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                {{ $category->category_name }} <span>({{ App\Models\Product::where('category_id',$category->id)->count() }})</span>
                                                <input {{ $category->id == @$_GET['category_id']?'checked':'' }} type="radio" name="category_id" class="category_search" value="{{ $category->id }}">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="shop-filter-item">
                                <h2>Filter by price</h2>
                                <div class="shopWidgetWraper">
                                    <div class="priceFilterSlider">
                                        <form action="#" method="get" class="clearfix">
                                            <div class="d-flex">
                                                <div class="col-lg-6 pe-2">
                                                    <label for="" class="form-label">Min</label>
                                                    <input type="text" id="min" class="form-control" placeholder="Min" value="{{ @$_GET['min'] }}">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="" class="form-label">Max</label>
                                                    <input type="text" id="max" class="form-control" placeholder="Max" value="{{ @$_GET['max'] }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mt-4">
                                                <button type="button" class="form-control bg-light range_search">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="shop-filter-item">
                                <h2>Color</h2>
                                <ul>
                                    @foreach ( $colors as $color )
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                {{ $color->color_name }} <span>({{ App\Models\Inventory::where('color_id',$color->id)->count() }})</span>
                                                <input type="radio" {{ $color->id == @$_GET['color_id']?'checked':'' }} name="color_id" value="{{ $color->id }}" class="color_search">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="shop-filter-item">
                                <h2>Size</h2>
                                <ul>
                                    @foreach ( $sizes as $size )
                                    <li>
                                        <label class="topcoat-radio-button__label">
                                            {{ $size->size_name }} <span>({{ App\Models\Inventory::where('size_id',$size->id)->count() }})</span>
                                            <input type="radio" name="size_id" {{ $color->id == @$_GET['size_id']?'checked':'' }} class="size_search" value="{{ $size->id }}">
                                            <span class="topcoat-radio-button"></span>
                                        </label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="shop-filter-item tag-widget">
                                <h2>Popular Tags</h2>
                                <ul>
                                    @foreach ( $tags as $tag ) 
                                        <li><button class="btn btn-light tag {{ $tag->id == @$_GET['tag']?'bg-warning':'' }}" value="{{ $tag->id }}">{{ $tag->tag_name }}</button></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="shop-section-top-inner">
                        <div class="shoping-product">
                            <p>We found <span>{{ $products->count() }} items</span> for you!</p>
                        </div>
                        <div class="short-by">
                            <ul>
                                <li>
                                    Sort by: 
                                </li>
                                <li>
                                    <select class="sort">
                                        <option value="">Default Sorting</option>
                                        <option value="1" {{ @$_GET['sort'] == 1?'selected':'' }}>Price Low To High</option>
                                        <option value="2" {{ @$_GET['sort'] == 2?'selected':'' }}>Price High To Low</option>
                                        <option value="3" {{ @$_GET['sort'] == 3?'selected':'' }}>Name (A-Z)</option>
                                        <option value="4" {{ @$_GET['sort'] == 4?'selected':'' }}>Name (Z-A)</option>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-wrap">
                        <div class="row align-items-center">
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
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
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
                            <h4 class="text-center mt-5">No Product Found</h4>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- product-area-end -->
@endsection
@section('footer_script')

@endsection