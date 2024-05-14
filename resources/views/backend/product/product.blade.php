@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h6>Add product</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">{{ __('Category list') }}</label>
                                    <select name="category_id" class="form-control category" id="Category">
                                        <option value="">Select Category</option>
                                        @foreach ( $categories as $category )
                                            <option value="{{ $category->id }}">{{ $category->category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">{{ __('Subcategory list') }}</label>
                                    <select name="subcategory_id" class="form-control subcategory" id="Subcategory">
                                        <option value="">Select Subcategory</option>
                                        @foreach ( $subcategories as $subcategory )
                                            <option value="{{ $subcategory->id }}">{{ $subcategory->subcategory }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">{{ __('Brand list') }}</label>
                                    <select name="brand_id" class="form-control" id="">
                                        <option value="">Select Brand</option>
                                        @foreach ( $brands as $brand )
                                            <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">{{ __('product name') }}</label>
                                    <input type="text" name="product_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">{{ __('product price') }}</label>
                                    <input type="number" name="price" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">{{ __('product discount (%)') }}</label>
                                    <input type="number" name="discount" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">{{ __('product short description') }}</label>
                                    <textarea name="short_description" id="myTextarea"  class="form-control" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">{{ __('product long description') }}</label>
                                    <textarea name="long_description" id="myTextarea2"  class="form-control" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">{{ __('product additional information') }}</label>
                                    <textarea name="additional_information" id="myTextarea3"  class="form-control" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">{{ __('product preview image') }}</label>
                                    <input type="file" name="preview" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">{{ __('product thumbnail images') }}</label>
                                    <input type="file" name="thumbnail[]" class="form-control" multiple>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Product Tags</label>
                                    <div>
                                        @foreach ( $tags as $tag ) 
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="form-check-input" id="checkInline1" multiple>
                                                <label class="form-check-label m-0" for="checkInline1">
                                                    {{ $tag->tag_name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-4 m-auto">
                                <button type="submit" class="w-100 btn btn-primary p-3">Add new product</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_script')
<script>
    $('.category').change(function(){
        var category_id = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: '/getsubcategory',
            data: { 'category_id':category_id },
            success: function( data ) {
                $('.subcategory').html(data);
            }
        });
    })
</script>
<script>
    ClassicEditor
        .create(document.querySelector("#myTextarea"))
        .catch(error => {
            console.error( error );
    } );
    ClassicEditor
        .create(document.querySelector("#myTextarea2"))
        .catch(error => {
            console.error( error );
    } );
    ClassicEditor
        .create(document.querySelector("#myTextarea3"))
        .catch(error => {
            console.error( error );
    } );
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
@endsection