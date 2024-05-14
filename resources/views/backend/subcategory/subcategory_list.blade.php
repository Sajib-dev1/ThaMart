@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-8 m-auto grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="card-title">Category Table</h6>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addsubcategoryModal">
                        <i class="link-icon" data-feather="file-plus"></i>  Add Subcategory
                    </button>
                </div>
                <p class="card-description">Add class <code>.table-hover</code></p>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category Name</th>
                                <th>Subcategory Name</th>
                                <th>Create time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $subcategories as $sl=>$subcategory ) 
                                <tr>
                                    <th>{{ $sl+1 }}</th>
                                    <td>{{ $subcategory->rel_to_cat->category }}</td>
                                    <td>{{ $subcategory->subcategory }}</td>
                                    <td>{{ $subcategory->created_at->diffForhumans() }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-icon" data-toggle="modal" data-target="#editsubcategoryModal{{ $subcategory->id }}">
                                            <i data-feather="check-square"></i>
                                        </button>
                                        <button type="button" data-link="{{ route('subcategory.soft.delete',$subcategory->id) }}" class="btn btn-danger btn-icon cat-soft-del">
                                            <i data-feather="trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end mt-4">
                        {{ $subcategories->links('backend.paginate.paginate') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->

  <!-- Modal add subcategory -->
  <div class="modal fade" id="addsubcategoryModal" tabindex="-1" role="dialog" aria-labelledby="addsubcategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addsubcategoryModalLabel">Add Subcategory</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('subcategory.store') }}" method="post" enctype="multipart/form-data" id="mycategory">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <label for="" class="form-label">Add Category</label>
                        <select name="category_id" class="form-control" id="">
                            <option value="">Select Category</option>
                            @foreach ( $categories as $category )
                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-12">
                        <label for="" class="form-label">Add Subcategory</label>
                        <input type="text" name="subcategory" class="form-control">
                        @error('subcategory')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
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

  @foreach ( $subcategories as $sl=>$subcategory )
    <!-- Modal Edit category -->
    <div class="modal fade" id="editsubcategoryModal{{ $subcategory->id }}" tabindex="-1" role="dialog" aria-labelledby="editsubcategoryModalLabel{{ $subcategory->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="editsubcategoryModalLabel{{ $subcategory->id }}"><i data-feather="check-square"></i> Edit Category</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form action="{{ route('subcategory.update',$subcategory->id) }}" method="post" enctype="multipart/form-data" id="mycategory">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="" class="form-label">Edit Subcategory</label>
                            <select name="category_id" class="form-control" id="">
                                <option value="">Select Category</option>
                                @foreach ( $categories as $category )
                                    <option value="{{ $category->id }}" {{ $subcategory->category_id == $category->id ?'selected':'' }}>{{ $category->category }}</option>
                                    
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <label for="" class="form-label">Edit Subcategory</label>
                            <input type="text" name="subcategory" class="form-control" value="{{ $subcategory->subcategory }}">
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
