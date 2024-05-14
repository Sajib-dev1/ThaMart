@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Product List</h4>
                </div>
                <div class="card-body">
                    <table class="table table-borderd">
                        <tr>
                            <th>SL</th>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Product price</th>
                            <th>Product discount</th>
                            <th>Product after discount</th>
                            <th>Product SKU</th>
                            <th>Status</th>
                            <th>Status upcomming</th>
                            <th>Action</th>
                        </tr>

                        @foreach ( $products as $sl=>$product ) 
                            <tr>
                                <td>{{ $sl+1 }}</td>
                                <td>
                                    <img src="{{ asset('uploads/product/preview') }}/{{ $product->preview }}" class="alert_i" alt="">
                                </td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->price }}</td>
                                <td>
                                    @if ($product->discount == null)
                                    <p style="color: #d7d4d4"><i>null</i></p>
                                       @else 
                                       {{ $product->discount }}
                                    @endif
                                </td>
                                <td>{{ $product->after_discount }}</td>
                                <td>{{ $product->sku }}</td>
                                <td>
                                    <button class="btn btn-{{ $product->status == 1?'success':'danger' }} status"  data-id="{{ $product->id }}" value="{{ $product->status }}">{{ $product->status == 1?'ON':'OFF' }}</button>
                                </td>
                                <td>
                                    <button class="btn btn-{{ $product->upcomming_status == 1?'success':'danger' }} upcomming_status"  data-id="{{ $product->id }}" value="{{ $product->upcomming_status }}">{{ $product->upcomming_status == 1?'ON':'OFF' }}</button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success btn-icon" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $product->id }}">
                                        <i data-feather="eye"></i>
                                    </button>
                                    <a href="{{ route('inventory.list',$product->id) }}" class="btn btn-primary btn-icon">
                                        <i data-feather="archive"></i>
                                    </a>
                                    <a href="{{ route('product.delete',$product->id) }}" type="button" class="btn btn-danger btn-icon product-del">
                                        <i data-feather="trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="d-flex justify-content-end mt-4">
                        {{ $products->links('backend.paginate.paginate') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
  
    @foreach ( $products as $product )
        
  <!-- Modal -->
  <div class="modal fade" id="exampleModal{{ $product->id }}" tabindex="-1" aria-labelledby="exampleModalLabel{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel{{ $product->id }}">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-borderd">
                        <tr>
                            <th><b>Product Name : </b></th>
                            <td>{{ $product->product_name }}</td>
                        </tr>
                        <tr>
                            <th><b>Author Name : </b></th>
                            <td>{{ $product->rel_to_user->name }}</td>
                        </tr>
                        <tr>
                            <th><b>Category Name : </b></th>
                            <td>{{ $product->rel_to_category->category }}</td>
                        </tr>
                        <tr>
                            <th><b>Subcategory Name : </b></th>
                            <td>
                                @if ($product->subcategory_id == null)
                                <p style="color: #d7d4d4"><i>null</i></p>
                                @else
                                <td>{{ $product->rel_to_subcategory->subcategory }}</td>
                                @endif
                            </td>
                            
                        </tr>
                        <tr>
                            <th><b>Product Name : </b></th>
                            <td>{{ $product->product_name }}</td>
                        </tr>
                        <tr>
                            <th><b>Product Price : </b></th>
                            <td>{{ $product->price }}</td>
                        </tr>
                        <tr>
                            <th><b>Product Discount : </b></th>
                            <td>{{ $product->discount }}</td>
                        </tr>
                        <tr>
                            <th><b>Product After Discount : </b></th>
                            <td>{{ $product->after_discount }}</td>
                        </tr>
                        <tr>
                            <th><b>Product Brand name : </b></th>
                            @if ($product->brand_id == null)
                            <p style="color: #d7d4d4"><i>No Brand</i></p>
                            @else
                            <td>{{ $product->rel_to_brand->brand_name }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th><b>Product SKU : </b></th>
                            <td>{{ $product->sku }}</td>
                        </tr>
                        <tr>
                            <th><b>Product Slug : </b></th>
                            <td>{{ $product->slug }}</td>
                        </tr>
                        <tr>
                            <th><b>Product Short Description : </b></th>
                            <td>{!! $product->short_description !!}</td>
                        </tr>
                        <tr>
                            <th><b>Product Long Description : </b></th>
                            <td>{!! $product->long_description !!}</td>
                        </tr>
                        <tr>
                            <th><b>Product Additional Information : </b></th>
                            <td>{!! $product->additional_information !!}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  @endforeach
@endsection
@section('footer_script')
<script>
    $('.upcomming_status').click(function(){
        if($(this).val() != 1){
            $(this).attr('value',1);
        }
        else{
            $(this).attr('value',0);
        }
        var product_id = $(this).attr('data-id');
        var status = $(this).val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $.ajax({
            type: "POST",
            url: '/getupcommingproductstatus',
            data: { 'product_id':product_id,'status':status },
            success: function( data ) {
            }
        });
    })
</script>
<script>
    $('.status').click(function(){
        if($(this).val() != 1){
            $(this).attr('value',1);
        }
        else{
            $(this).attr('value',0);
        }
        var product_id = $(this).attr('data-id');
        var status = $(this).val();

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $.ajax({
                type: "POST",
                url: '/getproductstatus',
                data: { 'product_id':product_id,'status':status },
                success: function( data ) {
                }
            });

    });
</script>
<script>
    $('.product-del').click(function(){
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