@extends('frontend.master')
@section('content')
<!-- start wpo-page-title -->
@include('frontend.incrouad.bladecomponet')
<!-- end page-title -->

<div class="container">
    <div class="row my-5">
        @include('frontend.incrouad.profile_sidebar')
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header p-2 customer">
                    <h3>My Orders</h3>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="profile_list">
                        <table class="table table-borderd">
                            <tr>
                                <th>SL</th>
                                <th>Order Id</th>
                                <th>Total</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            @foreach ( $orders as $sl=>$order )  
                                <tr>
                                    <td>{{ $sl+1 }}</td>
                                    <td>{{ $order->order_id }}</td>
                                    <td>{{ $order->total }}</td>
                                    <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        @if ($order->status == 0)
                                           <span class="badge bg-secondary">placed</span>
                                        @elseif ($order->status == 1)
                                           <span class="badge bg-primary">processing</span>
                                        @elseif ($order->status == 2)
                                           <span class="badge bg-warning">Shipping</span>
                                        @elseif ($order->status == 3)
                                           <span class="badge bg-info">Ready for deliver</span>
                                        @elseif ($order->status == 4)
                                           <span class="badge bg-success">Recevid</span>
                                        @elseif ($order->status == 5)
                                           <span class="badge bg-danger">Cancel</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($order->status == 5)
                                        @elseif ($order->status == 0)
                                            @if (App\Models\CancelOrder::where('order_id',$order->order_id)->exists())
                                                <button class="btn btn-warning btn-sm">Cancel order request pending</button>
                                            @else 
                                                <a href="{{ route('cancel.order',$order->id) }}" class="btn btn-dark btn-sm">Cancel order request..</a>
                                            @endif
                                        @elseif ($order->status == 4) 
                                                @if (App\Models\ReturnProduct::where('order_id',$order->order_id)->exists())
                                                    <button class="btn btn-warning btn-sm">request pending..</button>
                                                @else 
                                                    <a href="{{ route('return.product',$order->id) }}" class="btn btn-primary btn-sm">Requrn product..</a>
                                                    <a target="_blank" href="{{ route('download.invoice',$order->id) }}" class="btn btn-info btn-sm">Invouce Down</a>
                                                @endif
                                        @else
                                            <a target="_blank" href="{{ route('download.invoice',$order->id) }}" class="btn btn-info btn-sm">Invouce Down</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  
@endsection