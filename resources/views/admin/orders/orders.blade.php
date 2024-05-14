@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-10 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>All Orders</h3>
            </div>
            <div class="card-body">
                <table class="table table-borderd">
                    <tr>
                        <th>SL</th>
                        <th>Order id</th>
                        <th>total</th>
                        <th>Order Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                    @foreach ( $orders as $sl=>$order )
                        <tr>
                            <td>{{ $sl+1 }}</td>
                            <td>{{ $order->order_id }}</td>
                            <td>{{ $order->total }}</td>
                            <td>{{ $order->created_at->diffForhumans() }}</td>
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
                                   <span class="badge bg-success">Delivery</span>
                                @elseif ($order->status == 5)
                                   <span class="badge bg-danger">Cancel</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('order.status.update',$order->id) }}" method="post">
                                    @csrf
                                    <div class="dropdown">
                                        <button class="btn" type="button" data-toggle="dropdown" aria-expanded="false">
                                        Change Status
                                        </button>
                                        <div class="dropdown-menu">
                                            <button name="status" value="0" style="background: #{{ $order->status == 0?'ddd':'' }}" class="dropdown-item p-2">placed</button>
                                            <button name="status" value="1" style="background: #{{ $order->status == 1?'ddd':'' }}" class="dropdown-item p-2">processing</button>
                                            <button name="status" value="2" style="background: #{{ $order->status == 2?'ddd':'' }}" class="dropdown-item p-2">Shipping</button>
                                            <button name="status" value="3" style="background: #{{ $order->status == 3?'ddd':'' }}" class="dropdown-item p-2">Ready for deliver</button>
                                            <button name="status" value="4" style="background: #{{ $order->status == 4?'ddd':'' }}" class="dropdown-item p-2">Delivery</button>
                                            <button name="status" value="5" style="background: #{{ $order->status == 5?'ddd':'' }}" class="dropdown-item p-2">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection