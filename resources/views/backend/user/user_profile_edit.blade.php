@extends('layouts.admin')
@section('content')
<style>
    .image-flex{
        position: relative;
    }
    .image-css{
        position: absolute;
        top: 35%;
        right: 25px;
        width: 25px;
        height: 20px;
        transform: translateY(-50%);
    }
</style>
<style>
    .input_submit{
        pointer-events: none;
    }
    .input_submit.active{
        pointer-events: auto;
    }
    .passwird_required{
        display: none;
    }
    .passwird_required ul{
        padding: 0;
        margin: 0;
        list-style: none;
    }
    .passwird_required ul li{
        margin-bottom: 8px;
        color: red;
        font-weight: 700;
    }
    .passwird_required ul li span{
        margin-right: 10px;
    }
    .passwird_required ul li span::before{
        content: '❌';
    }
    .passwird_required ul li.active{
        color: green;
    }
    .passwird_required ul li.active span::before{
        content: '✅';
    }
</style>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">user profile update</h6>
                <form action="{{ route('user.info.update') }}" method="POST" id="myform">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label">About Information</label>
                                <textarea name="about_info" class="form-control" id="" cols="30" rows="5">{{ Auth::user()->about_info }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter first name" value="{{ Auth::user()->name }}">
                            </div>
                        </div><!-- Col -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Email</label>
                                <input type="email" class="form-control" placeholder="Enter last name" selected value="{{ Auth::user()->email }}">
                            </div>
                        </div><!-- Col -->
                    </div><!-- Row -->
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Profetion</label>
                                <input type="text" name="profetion" class="form-control" placeholder="Enter your profetion" value="{{ Auth::user()->profetion }}">
                            </div>
                        </div><!-- Col -->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">country</label>
                                <select name="country" class="form-control country_id" id="Country">
                                    @foreach ( $countries as $country )
                                    <option value="{{ $country->id }}" {{ Auth::user()->country == $country->id ?'selected':'' }}>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                        </div><!-- Col -->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">city</label>
                                <select name="city" class="form-control city" id="City">
                                    @foreach ( $cities as $city )
                                        <option value="{{ $city->id }}" {{ Auth::user()->city == $city->id ?'selected':'' }}>{{ $city->name }}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                        </div><!-- Col -->
                    </div><!-- Row -->
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Address</label>
                                <input type="text" name="address" class="form-control" placeholder="Enter your address" value="{{ Auth::user()->address }}">
                            </div>
                        </div><!-- Col -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label dgdfhgh">web side</label>
                                <input type="text" name="web_url" class="form-control" placeholder="Enter your webside" value="{{ Auth::user()->web_url }}">
                            </div>
                        </div><!-- Col -->
                    </div><!-- Row -->
                    <button type="submit" class="btn btn-primary submit">Submit form</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">user profile update</h6>
                <form action="{{ route('user.password.update') }}" method="POST" id="mypass">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="passwordold">{{ __('old Password') }}</label>
                                <input type="password" class="form-control" name="old_password" id="passwordold" aria-describedby="passwordHelp" placeholder="Enter password">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" id="password_new" aria-describedby="passwordHelp" placeholder="Enter new password">
                                <img src="{{ asset('backend/images/eye-slesh.png') }}" onclick="pass()" class="image-css" id="pass-icon" alt="">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="passwordcon">{{ __('Confirm password') }}</label>
                                <input type="password" class="form-control" name="password_confirmation" id="passwordcon" aria-describedby="passwordHelp" placeholder="Enter Confirm password">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="passwird_required">
                                    <ul>
                                        <li class="lowarcase"><span></span>One Lowercase letter</li>
                                        <li class="capital"><span></span>One uppercase letter</li>
                                        <li class="number"><span></span>One number</li>
                                        <li class="special"><span></span>One special character</li>
                                        <li class="eight_charecters"><span></span>At last 8 character</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary active">Submit form</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <table class="table table-borderd">
                    <tr>
                        <th>SL</th>
                        <th>Icon</th>
                        <th>Action</th>
                    </tr>
                    @foreach ( $sociles as $sl=>$socil )
                        <tr>
                            <td>{{ $sl+1 }}</td>
                            <td><a href="{{ $socil->link }}"><i class="{{ $socil->socile_icon }}" style="font-family: fontawesome; font-style:normal; color:rgb(0, 0, 0); font-size:30px;"></i></a></td>
                            <td>
                                <a href="{{ $socil->link }}" target="_blank" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                <a href="{{ route('socile.delete',$socil->id) }}" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Icon List</h6>
                <div class="row">
                    <form action="{{ route('socile.store') }}" method="post">
                        @csrf
                        <div class="col-lg-12">
                            @php
                            $fonts = array(                             
                                'fa-twitter-square',                     
                                'fa-facebook-square',
                                'fa-linkedin-square',
                                'fa-twitter',                            
                                'fa-facebook',                           
                                'fa-github', 
                                'fa-pinterest',                          
                                'fa-pinterest-square',                   
                                'fa-google-plus-square',                 
                                'fa-google-plus', 
                                'fa-linkedin',
                                'fa-youtube-square',                     
                                'fa-youtube', 
                                'fa-youtube-play',                            
                                'fa-stack-overflow',                     
                                'fa-instagram',                          
                                'fa-flickr',  
                                'fa-skype',
                                'fa-facebook-official',                  
                                'fa-pinterest-p',                        
                                'fa-whatsapp',                                                       
                            );
                        @endphp
                        </div>
                        <div class="col-lg-12">
                            @foreach ( $fonts as $icon )
                                <button type="button" style="border: none" class="btn btn-info my-2"><i data-icon="{{ $icon }}" class="socile_btn {{ $icon }}" style="font-family: fontawesome; font-style:normal; color:rgb(0, 0, 0)"></i></button>
                                
                            @endforeach
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group socile-icon">
                                <label for="icon">{{ __('Socile icon') }}</label>
                                <input type="text" class="form-control" name="socile_icon" id="icon" placeholder="Enter socile icon">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="link">{{ __('Socile Link') }}</label>
                                <input type="text" class="form-control" name="link" placeholder="Enter socile icon">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit form</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('footer_script')
    <script>
        $('.country_id').change(function(){
            var country_id = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: '/getusercity',
                data: { 'country_id':country_id },
                success: function( data ) {
                    $('.city').html(data)
            }
        });
        })
    </script>
    <script>
        $(document).ready(function() { $("#Country").select2(); });
        $(document).ready(function() { $("#City").select2(); });
    </script>
    <script>
        $( "#myform" ).validate({
            rules: {
                about_info: {
                    required: true
                },
                name: {
                    required: true
                },
                profetion: {
                    required: true,
                },
                country: {
                    required: true,
                },
                city: {
                    required: true,
                },
                address: {
                    required: true,
                },
                web_url: {
                    required: true,
                    url: true
                },
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
        @if(Session::has('update'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
                toastr.success("{{ session('update') }}");
        @endif
        @if(Session::has('wrong'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
                toastr.error("{{ session('wrong') }}");
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
    <script>
        let a ;
        function pass(){
            if(a == 1){
                document.getElementById("password_new").type="password";
                document.getElementById("pass-icon").src="{{ asset('backend/images/eye-slesh.png') }}";
                a=0;
            }
            else{
                document.getElementById("password_new").type="text";
                document.getElementById("pass-icon").src="{{ asset('backend/images/show.png') }}";
                a=1;
            }
        }
    </script>
    <script>
        $( "#mypass" ).validate({
            rules: {
                old_password: 'required',
                password: 'required',
                password_confirmation: {
                    required: true,
                    equalTo : "#password_new",
                }
            }
        })
    </script>
    <script>
        $('#password_new').on('focus',function(){
            $('.passwird_required').slideDown();
        })
        $('#password_new').on('blur',function(){
            $('.passwird_required').slideUp();
        })
    
        $('#password_new').on('keyup',function(){
            passValue = $(this).val();
    
            if(passValue.match(/[a-z]/g)){
                $('.lowarcase').addClass('active');
            }
            else{
                $('.lowarcase').removeClass('active');
            }
    
            if(passValue.match(/[A-Z]/g)){
                $('.capital').addClass('active');
            }
            else{
                $('.capital').removeClass('active');
            }
    
            if(passValue.match(/[0-9]/g)){
                $('.number').addClass('active');
            }
            else{
                $('.number').removeClass('active');
            }
    
            if(passValue.match(/[!@#$%^&*]/g)){
                $('.special').addClass('active');
            }
            else{
                $('.special').removeClass('active');
            }
    
            if(passValue.length == 8 || passValue.length >8){
                $('.eight_charecters').addClass('active');
            }
            else{
                $('.eight_charecters').removeClass('active');
            }
    
            $('.passwird_required ul li').each(function(index,el){
                if(!$(this).hasClass('active')){
                    $('.input_submit').removeClass('active');
                }
                else{
                    $('.input_submit').addClass('active');
                }
            })
        })
    </script>
        <script>
            $('.socile_btn').click(function(){
                var icon = $(this).attr('data-icon');
                $('#icon').attr('value',icon);
            })
        </script>

@endsection
