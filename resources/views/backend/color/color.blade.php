@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h5>Color List</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Add Color
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-borderd">
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        @foreach ( $colors as $sl=>$color ) 
                            <tr>
                                <td>{{ $sl+1 }}</td>
                                <td>{{ $color->color_name }}</td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center" style="height:30px;width:100px; border:1px solid #b8b7b7; background-color:{{ $color->color_code }}"><p style=" color:#fce9e9">{{ $color->color_code }}</p></div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-icon">
                                        <i data-feather="trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="d-flex justify-content-end mt-4">
                        {{ $colors->links('backend.paginate.paginate') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h5>Size List</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sizeModal">
                            Add size
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-borderd">
                        <tr>
                            <th>SL</th>
                            <th>Size Name</th>
                            <th>Action</th>
                        </tr>
                        @foreach ( $sizes as $sl=>$size ) 
                            <tr>
                                <td>{{ $sl+1 }}</td>
                                <td>{{ $size->size_name }}</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-icon">
                                        <i data-feather="trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="d-flex justify-content-end mt-4">
                        {{ $sizes->links('backend.paginate.paginate') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

      <!-- Modal color -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Add Color</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('color.store') }}" method="post">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="" class="form-label">Color Name</label>
                                    <input type="text" name="color_name" class="form-control">
                                    @error('color_name')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Color Code</label>
                                    <input type="text" name="color_code" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
    </div>
  </div>

      <!-- Modal size -->
  <div class="modal fade" id="sizeModal" tabindex="-1" aria-labelledby="sizeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="sizeModalLabel">Add Size</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('size.store') }}" method="post">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="" class="form-label">Size Name</label>
                                    <input type="text" name="size_name" class="form-control">
                                    @error('size_name')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    </script>
@endsection