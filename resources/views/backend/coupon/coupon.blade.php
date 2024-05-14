@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            @if (session('success_up'))
                <div class="alert alert-success">{{ session('success_up') }}</div>
            @endif
            <div class="card-header">
                <h5>Coupon table</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderd">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Coupon name</th>
                            <th>Type</th>
                            <th>amount</th>
                            <th>date</th>
                            <th>status</th>
                            <th>Limit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $coupons as $sl=>$coupon )  
                            <tr>
                                <td>{{ $sl+1 }}</td>
                                <td>{{ $coupon->coupon }}</td>
                                <td>{{ $coupon->type == 1?'parcentage':'Solid' }}</td>
                                <td>{{ $coupon->amount }}</td>
                                <td>{{ $coupon->validaty }}</td>
                                <td class="toogle_btn text-center">
                                    <button class="btn btn-{{ $coupon->status == 1?'success':'danger' }} status" value="{{ $coupon->status }}" data-id="{{ $coupon->id }}">OFF</button>
                                </td>
                                <td>{{ $coupon->limit }}</td>
                                <td>
                                    <a href="{{ route('coupon.delete',$coupon->id) }}" class="btn btn-danger btn-icon">
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
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
              <h6 class="card-title">Add Coupon</h6>
                  <form class="forms-sample" action="{{ route('coupon.store') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group">
                          <label for="exampleInputUsername1">Coupon name</label>
                          <input type="text" class="form-control @error('coupon')is-invalid @enderror" name="coupon">
                          @error('coupon')
                              <strong class="text-danger">{{ $message }}</strong>
                          @enderror
                      </div>
                      <div class="form-group">
                          <label for="exampleInputUsername1">Coupon Type</label>
                          <select name="type" class="form-control @error('type')is-invalid @enderror" id="">
                            <option value="">Select type</option>
                            <option value="1">Parcentage</option>
                            <option value="2">solid</option>
                          </select>
                          @error('type')
                              <strong class="text-danger">{{ $message }}</strong>
                          @enderror
                      </div>
                      <div class="form-group">
                          <label for="exampleInputEmail1">Amount</label>
                          <input type="number" class="form-control @error('amount')is-invalid @enderror" name="amount">
                          @error('amount')
                              <strong class="text-danger">{{ $message }}</strong>
                          @enderror
                      </div>
                      <div class="form-group">
                          <label for="exampleInputEmail1">Validaty</label>
                          <input type="date" class="form-control @error('validaty')is-invalid @enderror" name="validaty">
                          @error('validaty')
                              <strong class="text-danger">{{ $message }}</strong>
                          @enderror
                      </div>
                      <div class="form-group">
                          <label for="exampleInputEmail1">Limit</label>
                          <input type="number" class="form-control @error('limit')is-invalid @enderror" name="limit">
                          @error('limit')
                              <strong class="text-danger">{{ $message }}</strong>
                          @enderror
                      </div>
                      <button type="submit" class="btn btn-primary mr-2">Submit</button>
                  </form>
            </div>
        </div>
    </div>  
</div>  
@endsection
@section('footer_script')
    <script>
        $('.status').click(function(){
            if($(this).val() != 1){
                $(this).attr('value',1);
            }
            else{
                $(this).attr('value',0);
            }
            var coupon_id = $(this).attr('data-id');
            var status = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $.ajax({
                type: "POST",
                url: '/getcouponctstatus',
                data: { 'coupon_id':coupon_id,'status':status },
                success: function( data ) {
                }
            });
        })
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
                toastr.error("{{ session('delete') }}");
        @endif
    </script>
@endsection