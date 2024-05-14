@extends('frontend.master')
@section('content')
<!-- start wpo-page-title -->
@include('frontend.incrouad.bladecomponet')
<!-- end page-title -->

<div class="container">
    <div class="row my-5">
        @include('frontend.incrouad.profile_sidebar')
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header p-5 customer">
                    <h3>My Profile</h3>
                    <div class="profile_list">
                        <div class="profile_head d-flex justify-content-between align-items-center py-4">
                            <h5>Profile Name</h5>
                            <a href="{{ route('customer.edit.profile') }}" class="btn btn-success btn-sm">Edit Profile</a>
                        </div>
                        <div class="my_infirmation d-flex">
                            <p class="item_list">Join date :</p><p>{{ Auth::guard('customer')->user()->created_at->format('d-M-Y') }}</p>
                        </div>
                        <div class="my_infirmation d-flex">
                            <p class="item_list">Photo :</p><p style="border: 1px solid #07d133dc"> <img width="100" src="{{ asset('uploads/customer') }}/{{ Auth::guard('customer')->user()->photo }}" alt=""></p>
                        </div>
                        <div class="my_infirmation d-flex">
                            <p class="item_list">Name :</p><p>{{ Auth::guard('customer')->user()->fname.' '.Auth::guard('customer')->user()->lname }}</p>
                        </div>
                        <div class="my_infirmation d-flex">
                            <p class="item_list">Email Address :</p><p>{{ Auth::guard('customer')->user()->email }}</p>
                        </div>
                        <div class="my_infirmation d-flex">
                            <p class="item_list">Phone :</p><p> {{ Auth::guard('customer')->user()->phone }}</p>
                        </div>
                        <div class="my_infirmation d-flex">
                            <p class="item_list">Zip :</p><p>{{ Auth::guard('customer')->user()->zip }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection