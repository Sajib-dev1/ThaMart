@extends('frontend.master')
@section('content')
<!-- start wpo-page-title -->
@include('frontend.incrouad.bladecomponet')
<!-- end page-title -->

<!-- end page-title -->
<div class="container">
    <div class="row">
        <div class="col-lg-8 m-auto">
            <div class="card m-5">
                <div class="card-header">
                    <h4>Return product</h4>
                    <p><strong>Order Id :</strong> {{ $detels->order_id }}</p>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                </div>
                <div class="card-body">
                    <form action="{{ route('return.product.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input type="hidden" name="order_id" value="{{ $detels->order_id }}">
                            <label for="" class="form-label">Return product reson</label>
                            <textarea name="resion" class="form-control" id="" cols="30" rows="5"></textarea>
                            @error('resion')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Product Image</label>
                            <input type="file" name="image" class="form-control">
                            @error('image')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>   
@endsection