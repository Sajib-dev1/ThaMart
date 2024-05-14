@extends('frontend.master')
@if(session('success'))
@section('content')
<!-- start wpo-page-title -->
@include('frontend.incrouad.bladecomponet')
<!-- end page-title -->

<div class="container">
    <div class="row mt-5 my-5">
        <div class="col-lg-10 m-auto">
            <div class="card">
                <div class="card-header">
                    <h6>{{ session('success') }}</h6>
                </div>
                <div class="card-body">
                    <img src="{{ asset('frontend/images/order-success.svg') }}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@else
@php
    abort('404');
@endphp
@endif