@extends('frontend.master')
@section('content')
    <div class="container mt-5 mb-3">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Category From API</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="div">
                                    <h5>Get Category Link</h5>
                                    <div class="div my-3" style="padding: 20px; background:rgba(42, 42, 42, 0.655); color:#fff">
                                        http://127.0.0.1:8000/api/category/api
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <h5>Gategory Show form API</h5>
                            @foreach ( $categories as $category ) 
                                <div class="col-lg-3 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <img src="{{ env('CATEGORY_IMAGE') }}/{{ $category->icon }}" width="50" alt="">
                                            <p>{{ $category->category }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection