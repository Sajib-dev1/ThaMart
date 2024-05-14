@extends('frontend.master')
@section('title')
    Customer Password
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
                <div class="card-header p-3 customer">
                    <h3>Password Update</h3>
                    @if (session('updated'))
                        <div class="alert alert-success">{{ session('updated') }}</div>
                    @endif
                    <div class="profile_list">
                        <form action="{{ route('customer.update.password') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-8 m-auto">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Current Password</label>
                                                <input type="password" name="current_password" class="form-control @error('current_password')is-invalid @enderror" placeholder="old password">
                                                @error('current_password')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="" class="form-label">Password</label>
                                                <input type="password" name="password" class="form-control @error('password')is-invalid @enderror" placeholder="New password">
                                                @error('password')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="" class="form-label">Confirm Password</label>
                                                <input type="password" name="password_confirmation" class="form-control @error('password_confirmation')is-invalid @enderror" placeholder="confirm password">
                                                @error('password_confirmation')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-primary">Update Password</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>     
@endsection