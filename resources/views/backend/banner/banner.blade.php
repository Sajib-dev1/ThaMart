@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-8 grid-margin stretch-card m-auto">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-title">Banner Table</h6>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addbannerModal">
                            <i class="link-icon" data-feather="file-plus"></i> Add Banner
                        </button>
                    </div>
                    <p class="card-description">Add class <code>.table-hover</code></p>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Type Name</th>
                                    <th>Image</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $banners as $sl=>$banner )  
                                    <tr>
                                        <th>{{ $sl+1 }}</th>
                                        <td>{{ $banner->title }}</td>
                                        <td>{{ $banner->rel_to_product_type->subcategory }}</td>
                                        <td>
                                            <img src="{{ asset('uploads/banner') }}/{{ $banner->image }}" alt="">
                                        </td>
                                        <td>{{ $banner->created_at->diffForhumans() }}</td>
                                        <td>
                                            <a href="{{ route('banner.delete',$banner->id) }}" class="btn btn-danger btn-icon">
                                                <i data-feather="trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
              </div>
        </div>
    </div>

      <!-- Modal add Banner -->
  <div class="modal fade" id="addbannerModal" tabindex="-1" role="dialog" aria-labelledby="addbannerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addbannerModalLabel">Add Banner</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('banner.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="form-group">
                        <label for="exampleInputUsername1">Title</label>
                        <input type="text" class="form-control" name="title" id="exampleInputUsername1" placeholder="Title" autocomplete="off">
                        @error('title')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">Product Type</label>
                        <select name="product_type" class="form-control" id="">
                            <option value="">Select Product Type</option>
                            @foreach ( $product_types as $product_type )
                                <option value="{{ $product_type->id }}">{{ $product_type->subcategory }}</option> 
                            @endforeach
                        </select>
                        @error('product_type')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">Image</label>
                        <input type="file" class="form-control" name="image" id="exampleInputUsername1" autocomplete="off" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        @error('image')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <img src="" width="150" id="blah" alt="">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection
@section('footer_script')
<script>
    @if(Session::has('success'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
        toastr.success("{{ session('success') }}");
    @endif

    @if(Session::has('delete'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
        toastr.error("{{ session('delete') }}");
    @endif
</script>    
@endsection