@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>Add Inventory</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('inventory.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product_info->id }}">
                        <div class="mb-3">
                            <label for="" class="form-label">Coloer Name</label>
                            <select name="color_id" class="form-control @error('color_id')is-invalid @enderror" id="">
                                <option value="">Select Color</option>
                                @foreach ( $colors as $color ) 
                                    <option value="{{ $color->id }}">{{ $color->color_name }}</option>
                                @endforeach
                            </select>
                            @error('color_id')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Size Name</label>
                            <select name="size_id" class="form-control @error('size_id')is-invalid @enderror" id="">
                                <option value="">Select size</option>
                                @foreach ( $sizes as $size ) 
                                    <option value="{{ $size->id }}">{{ $size->size_name }}</option>
                                @endforeach
                            </select>
                            @error('size_id')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Quantity</label>
                            <input type="number" name="quantity" class="form-control @error('quantity')is-invalid @enderror">
                            @error('quantity')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add Inventory</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5>{{ $product_info->product_name }}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderd">
                        <tr>
                            <th>SL</th>
                            <th>Color name</th>
                            <th>Size name</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                        @foreach ( $inventories as $sl=>$inventory )  
                            <tr>
                                <td>{{ $sl+1 }}</td>
                                <td>{{ $inventory->rel_to_color->color_name }}</td>
                                <td>{{ $inventory->rel_to_size->size_name }}</td>
                                <td>{{ $inventory->quantity }}</td>
                                <td>
                                    <a href="" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
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
@endsection