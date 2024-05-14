@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Delivery Charge Table</h6>
                <p class="card-description">Add class <code>.table-hover</code></p>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Delivery name</th>
                                <th>Amount</th>
                                <th>Created at</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $deliveries as $sl=>$delivery )  
                                <tr>
                                    <th>{{ $sl+1 }}</th>
                                    <td>{{ $delivery->delivery_type ==1?'inside':'outside' }}</td>
                                    <td>{{ $delivery->amount }}</td>
                                    <td>{{ $delivery->created_at->diffForhumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
          </div>
    </div>
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Update Delivery Charge</h6>
                <form class="forms-sample" action="{{ route('delivery.update') }}" method="post">
                    @csrf
                    <input type="hidden" name="delivery_inside_id" value="{{ $delivery_inside }}">
                    <input type="hidden" name="delivery_outside_id" value="{{ $delivery_outside }}">
                    <div class="form-group">
                        <label for="exampleInputUsername1">Size Name</label>
                        <select name="delivery_type" class="form-control" id="exampleInputUsername1" autocomplete="off">
                            <option value="">select delivery</option>
                            <option value="1">Inside</option>
                            <option value="2">Outside</option>
                        </select>
                        @error('delivery_type')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">Amount</label>
                        <input type="number" class="form-control" name="amount" id="exampleInputUsername1" placeholder="Size Name">
                        @error('amount')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
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