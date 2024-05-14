@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-8 m-auto grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="card-title">Category Table</h6>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addcategoryModal">
                        <i class="link-icon" data-feather="file-plus"></i> Add Category
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
                            @foreach ( $categories as $sl=>$category ) 
                                <tr>
                                    <th>{{ $sl+1 }}</th>
                                    <td>
                                        <img src="{{ asset('uploads/category') }}/{{ $category->icon }}" alt="">
                                    </td>
                                    <td>{{ $category->category }}</td>
                                    <td>{{ $category->created_at->diffForhumans() }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-icon" data-toggle="modal" data-target="#editcategoryModal{{ $category->id }}">
                                            <i data-feather="check-square"></i>
                                        </button>
                                        <button type="button" data-link="{{ route('category.soft.delete',$category->id) }}" class="btn btn-danger btn-icon cat-soft-del">
                                            <i data-feather="trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end mt-4">
                        {{ $categories->links('backend.paginate.paginate') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->

  <!-- Modal add category -->
  <div class="modal fade" id="addcategoryModal" tabindex="-1" role="dialog" aria-labelledby="addcategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addcategoryModalLabel">Add Category</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('add.category') }}" method="post" enctype="multipart/form-data" id="mycategory">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <label for="" class="form-label">Add Category</label>
                        <input type="text" name="category" class="form-control">
                        @error('category')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="col-lg-12">
                        <label for="" class="form-label">Category icon</label>
                        <input type="file" name="icon" class="form-control" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
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

  @foreach ( $categories as $sl=>$category )
    <!-- Modal Edit category -->
    <div class="modal fade" id="editcategoryModal{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="editcategoryModalLabel{{ $category->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="editcategoryModalLabel{{ $category->id }}"><i data-feather="check-square"></i> Edit Category</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form action="{{ route('category.update',$category->id) }}" method="post" enctype="multipart/form-data" id="mycategory">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="" class="form-label">Add Category</label>
                            <input type="text" name="category" class="form-control" value="{{ $category->category }}">
                            @error('category')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-12">
                            <label for="" class="form-label">Category icon</label>
                            <input type="file" name="icon" class="form-control" onchange="document.getElementById('editcat').src = window.URL.createObjectURL(this.files[0])">
                        </div>
                        <div class="col-lg-12 mt-3">
                            <img src="{{ asset('uploads/category') }}/{{ $category->icon }}" alt="" id="editcat" width="150">
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
