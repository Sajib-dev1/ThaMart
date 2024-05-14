@extends('frontend.master')
@section('content')
<!-- start wpo-page-title -->
@include('frontend.incrouad.bladecomponet')
<!-- end page-title -->
<div class="container">
    <div class="row my-5">
        <div class="col-lg-10 m-auto">
            <div class="card">
                <div class="card-header p-3 customer">
                    <h3>My Profile update</h3>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="profile_list">
                        <form action="{{ route('customer.update.profile') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">First Name</label>
                                        <input type="text" name="fname" class="form-control @error('fname')is-invalid @enderror" value="{{ Auth::guard('customer')->user()->fname }}">
                                        @error('fname')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Last Name</label>
                                        <input type="text" name="lname" class="form-control @error('lname')is-invalid @enderror" value="{{ Auth::guard('customer')->user()->lname }}">
                                        @error('lname')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Email</label>
                                        <input type="text" disabled value="{{ Auth::guard('customer')->user()->email }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Phone</label>
                                        <input type="text" name="phone" class="form-control @error('phone')is-invalid @enderror" value="{{ Auth::guard('customer')->user()->phone }}">
                                        @error('phone')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Zip</label>
                                        <input type="number" name="zip" class="form-control @error('zip')is-invalid @enderror" value="{{ Auth::guard('customer')->user()->zip }}">
                                        @error('zip')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Image</label>
                                        <input type="file" name="photo" class="form-control @error('image')is-invalid @enderror" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                        @error('photo')
                                            <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <img src="{{ asset('uploads/customer') }}/{{ Auth::guard('customer')->user()->photo }}" width="100" id="blah" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary m-auto">Update profile</button>
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