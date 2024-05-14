@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h6>Update uppcomming offer</h6>
                </div>
                <div class="card-body">
                    <form class="forms-sample" action="{{ route('upcomming.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{  $upcomming_offer->id }}">
                        <div class="form-group">
                            <label for="exampleInputUsername1">Product Name</label>
                            <input type="text" class="form-control" name="name" id="exampleInputUsername1" placeholder="Product sur Name" autocomplete="off" value="{{ $upcomming_offer->name }}">
                            @error('name')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1">Product Price</label>
                            <input type="text" class="form-control" name="price" id="exampleInputUsername1" placeholder="Product Price" autocomplete="off" value="{{ $upcomming_offer->price }}">
                            @error('price')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1">Product Discount(%)</label>
                            <input type="text" class="form-control" name="discount" id="exampleInputUsername1" placeholder="Product discount(%)" autocomplete="off" value="{{ $upcomming_offer->discount }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1">Date</label>
                            <input type="date" class="form-control" name="date" id="exampleInputUsername1" autocomplete="off" value="{{ $upcomming_offer->date }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1">Image</label>
                            <input type="file" class="form-control" name="image" id="exampleInputUsername1" autocomplete="off" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                            @error('image')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <img src="{{ asset('uploads/offer') }}/{{  $upcomming_offer->image }}" width="150" id="blah" alt="">
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="{{ route('dashboard') }}" class="btn btn-light">Cancel</a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Update New Offer up to 70%</h6>
                    <form class="forms-sample" action="{{ route('newoffer.update',$new_offer->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputUsername1">Title</label>
                            <input type="text" class="form-control" name="title" id="exampleInputUsername1" placeholder="Title" autocomplete="off" value="{{ $new_offer->title }}">
                            @error('title')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1">Sub Title</label>
                            <input type="text" class="form-control" name="sub_title" id="exampleInputUsername1" placeholder="Product Price" autocomplete="off" value="{{ $new_offer->sub_title }}">
                            @error('sub_title')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1">Image</label>
                            <input type="file" class="form-control" name="image" id="exampleInputUsername1" autocomplete="off" onchange="document.getElementById('new_offer').src = window.URL.createObjectURL(this.files[0])">
                            @error('image')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <img src="{{ asset('uploads/offer') }}/{{ $new_offer->image }}" width="150" id="new_offer" alt="">
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="{{ route('dashboard') }}" class="btn btn-light">Cancel</a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 grid-margin stretch-card mt-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Update New Offer up to 50%</h6>
                    <form class="forms-sample" action="{{ route('offer.update',$offer_info->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputUsername1">Title</label>
                            <input type="text" class="form-control" name="title" id="exampleInputUsername1" placeholder="Title" autocomplete="off" value="{{ $offer_info->title }}">
                            @error('title')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1">Sub Title</label>
                            <input type="text" class="form-control" name="sub_title" id="exampleInputUsername1" placeholder="Product Price" autocomplete="off" value="{{ $offer_info->sub_title }}">
                            @error('sub_title')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1">Image</label>
                            <input type="file" class="form-control" name="image" id="exampleInputUsername1" autocomplete="off" onchange="document.getElementById('offer').src = window.URL.createObjectURL(this.files[0])">
                            @error('image')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <img src="{{ asset('uploads/offer') }}/{{  $offer_info->image }}" width="150" id="offer" alt="">
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="{{ route('dashboard') }}" class="btn btn-light">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_script')
    <script>
        @if(Session::has('updated'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
                toastr.success("{{ session('updated') }}");
        @endif
    </script>
@endsection