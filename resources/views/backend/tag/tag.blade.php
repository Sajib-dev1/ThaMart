@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                    <h4>Tag List</h4>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addtagModal"><i class="link-icon" data-feather="file-plus"></i> Add Tag</button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-borderd">
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        @foreach ( $tags as $sl=>$tag ) 
                            <tr>
                                <td>{{ $sl+1 }}</td>
                                <td>{{ $tag->tag_name }}</td>
                                <td>
                                    <button type="button" data-link="{{ route('tag.delete',$tag->id) }}" class="btn btn-danger btn-icon tag-del">
                                        <i data-feather="trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="d-flex justify-content-end mt-4">
                        {{ $tags->links('backend.paginate.paginate') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    
  <!-- Modal add category -->
  <div class="modal fade" id="addtagModal" tabindex="-1" role="dialog" aria-labelledby="addtagModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addtagModalLabel">Add Tag</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('tag.store') }}" method="post" id="mytag">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <label for="" class="form-label">Add Tag</label>
                        <input type="text" name="tag_name" class="form-control">
                        @error('tag_name')
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
@endsection
@section('footer_script')
<script>
    $( "#mytag" ).validate({
        rules: {
            tag_name: {
                required: true,
            }
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
        @if(Session::has('delete'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
                toastr.success("{{ session('delete') }}");
        @endif
    </script>
        <script>
            $('.tag-del').click(function(){
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