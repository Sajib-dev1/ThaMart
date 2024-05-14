@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-8 m-auto grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="card-title">Subcategory Trashed Table</h6>
                    <a href="{{ route('category.list') }}" class="btn btn-primary">
                        <i class="link-icon" data-feather="align-center"></i>  Subcategory List
                    </a>
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
                                        <a href="{{ route('subcategory.restore',$subcategory->id) }}" title="restore" class="btn btn-success btn-icon">
                                            <i data-feather="corner-up-left"></i>
                                        </a>
                                        <button type="button" title="delete" data-link="{{ route('subcategory.delete',$subcategory->id) }}" class="btn btn-danger btn-icon cat-soft-del">
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
