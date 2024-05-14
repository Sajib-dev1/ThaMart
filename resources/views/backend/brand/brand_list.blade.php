@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-8 m-auto grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="card-title">Brand Table</h6>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addbrandModal">
                        <i class="link-icon" data-feather="file-plus"></i>  Add Brand
                    </button>
                </div>
                <p class="card-description">Add class <code>.table-hover</code></p>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category Icon</th>
                                <th>Category Name</th>
                                <th>Create time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $brands as $sl=>$brand ) 
                                <tr>
                                    <th>{{ $sl+1 }}</th>
                                    <td>
                                        <img src="{{ asset('uploads/brand') }}/{{ $brand->image }}" alt="">
                                    </td>
                                    <td>{{ $brand->brand_name }}</td>
                                    <td>{{ $brand->created_at->diffForhumans() }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-icon" data-toggle="modal" data-target="#editbrandModal{{ $brand->id }}">
                                            <i data-feather="check-square"></i>
                                        </button>
                                        <button type="button" data-link="{{ route('brand.delete',$brand->id) }}" class="btn btn-danger btn-icon cat-soft-del">
                                            <i data-feather="trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end mt-4">
                        {{ $brands->links('backend.paginate.paginate') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->

  <!-- Modal add category -->
  <div class="modal fade" id="addbrandModal" tabindex="-1" role="dialog" aria-labelledby="addbrandModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addbrandModalLabel">Add Brand</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('brand.store') }}" method="post" enctype="multipart/form-data" id="mycategory">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <label for="" class="form-label">Add Brand</label>
                        <input type="text" name="brand_name" class="form-control">
                        @error('brand_name')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="col-lg-12">
                        <label for="" class="form-label">Brand icon</label>
                        <input type="file" name="image" class="form-control" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                    </div>
                    <div class="col-lg-12 mt-3">
                        <img src="" alt="" id="blah" width="150">
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

  @foreach ( $brands as $sl=>$brand )
    <!-- Modal Edit category -->
    <div class="modal fade" id="editbrandModal{{ $brand->id }}" tabindex="-1" role="dialog" aria-labelledby="editbrandModalLabel{{ $brand->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="editbrandModalLabel{{ $brand->id }}"><i data-feather="check-square"></i> Edit Brand</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form action="{{ route('brand.update',$brand->id) }}" method="post" enctype="multipart/form-data" id="mycategory">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="" class="form-label">Edit brand</label>
                            <input type="text" name="category" class="form-control" value="{{ $brand->brand_name }}">
                            @error('category')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-12">
                            <label for="" class="form-label">Edit brand icon</label>
                            <input type="file" name="image" class="form-control" onchange="document.getElementById('editcat').src = window.URL.createObjectURL(this.files[0])">
                        </div>
                        <div class="col-lg-12 mt-3">
                            <img src="{{ asset('uploads/brand') }}/{{ $brand->image }}" alt="" id="editcat" width="150">
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
  @endforeach
@endsection
@section('footer_script')
    <script>
        $( "#mycategory" ).validate({
            rules: {
                category: {
                    required: true,
                },
                icon: {
                    required: true
                },
            }
        });
    </script>
    <script>
        @if(Session::has('success'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
                toastr.success("{{ session('success') }}");
        @endif
    </script>
    <script>
        $('.cat-soft-del').click(function(){
            let link = $(this).attr('data-link')
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href=link;
                }
            });
        })
    </script>
    @if (session('delete'))
        <script>
            Swal.fire({
            title: "Deleted!",
            text: "{{ session('delete') }}",
            icon: "success"
            });
        </script>
    @endif
@endsection
