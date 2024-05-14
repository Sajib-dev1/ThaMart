@extends('layouts.admin')
@section('content')
<div class="profile-page tx-13">
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="profile-header">
                <div class="cover">
                    <div class="gray-shade"></div>
                    <figure>
                        @if (Auth::user()->cover_photo == null)
                        <img src="https://via.placeholder.com/1148x272" class="img-fluid" alt="profile cover">
                        
                        @else
                        <img src="{{ asset('uploads/user') }}/{{ Auth::user()->cover_photo }}" class="img-fluid" alt="profile cover">
                        
                        @endif
                    </figure>
                    <div class="cover-body d-flex justify-content-between align-items-center">
                        <div>
                            <button type="button" class="" data-toggle="modal" data-target="#photoModal" style="border: none; background:none">
                                @if (Auth::user()->cover_photo == null)
                                    <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" style="border-radius:50%" />
                                @else
                                    <img src="{{ asset('uploads/user') }}/{{ Auth::user()->photo_photo }}" class="img-fluid" alt="profile cover" style="border-radius:50%">
                                @endif
                              </button>
                            <span class="profile-name">{{ Auth::user()->name }}</span>
                        </div>
                        <div class="d-none d-md-block">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#coverModal">
                                Edit profile
                              </button>
                        </div>
                    </div>
                </div>
                <div class="header-links">
                    <ul class="links d-flex align-items-center mt-3 mt-md-0">
                        <li class="header-link-item d-flex align-items-center active">
                            <i class="mr-1 icon-md" data-feather="columns"></i>
                            <a class="pt-1px d-none d-md-block" href="#">Timeline</a>
                        </li>
                        <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center">
                            <i class="mr-1 icon-md" data-feather="user"></i>
                            <a class="pt-1px d-none d-md-block" href="#">About</a>
                        </li>
                        <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center">
                            <i class="mr-1 icon-md" data-feather="users"></i>
                            <a class="pt-1px d-none d-md-block" href="#">Friends <span
                                    class="text-muted tx-12">3,765</span></a>
                        </li>
                        <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center">
                            <i class="mr-1 icon-md" data-feather="image"></i>
                            <a class="pt-1px d-none d-md-block" href="#">Photos</a>
                        </li>
                        <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center">
                            <i class="mr-1 icon-md" data-feather="video"></i>
                            <a class="pt-1px d-none d-md-block" href="#">Videos</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row profile-body">
        <!-- left wrapper start -->
        <div class="d-none d-md-block col-md-4 col-xl-3 left-wrapper">
            <div class="card rounded">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="card-title mb-0">About</h6>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="edit-2"
                                        class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="git-branch"
                                        class="icon-sm mr-2"></i> <span class="">Update</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye"
                                        class="icon-sm mr-2"></i> <span class="">View all</span></a>
                            </div>
                        </div>
                    </div>
                    <p>{{ Auth::user()->about_info }}</p>
                    <div class="mt-3">
                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Joined:</label>
                        <p class="text-muted">{{ Auth::user()->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="mt-3">
                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Lives:</label>
                        <p class="text-muted">{{ Auth::user()->rel_to_country->name }}, {{ Auth::user()->rel_to_city->name }}</p>
                    </div>
                    <div class="mt-3">
                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Email:</label>
                        <p class="text-muted">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="mt-3">
                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Website:</label>
                        <p class="text-muted">{{ Auth::user()->web_url }}</p>
                    </div>
                    <div class="mt-3 d-flex social-links">
                        @foreach ( $sociles->take(4) as $socile ) 
                            <a href="{{ $socile->link }}" target="_blank"
                                class="btn d-flex align-items-center justify-content-center border mr-2 btn-icon github">
                                <i class="{{ $socile->socile_icon }}" style="font-family: fontawesome; font-style:normal; color:rgb(0, 0, 0); font-size:15px;"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- left wrapper end -->
        <!-- middle wrapper start -->
        <div class="col-md-8 col-xl-6 middle-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="card rounded">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img class="img-xs rounded-circle" src="https://via.placeholder.com/37x37" alt="">
                                    <div class="ml-2">
                                        <p>Mike Popescu</p>
                                        <p class="tx-11 text-muted">1 min ago</p>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="dropdownMenuButton2"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg pb-3px" data-feather="more-horizontal"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                        <a class="dropdown-item d-flex align-items-center" href="#"><i
                                                data-feather="meh" class="icon-sm mr-2"></i> <span
                                                class="">Unfollow</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="#"><i
                                                data-feather="corner-right-up" class="icon-sm mr-2"></i> <span
                                                class="">Go to post</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="#"><i
                                                data-feather="share-2" class="icon-sm mr-2"></i> <span
                                                class="">Share</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="#"><i
                                                data-feather="copy" class="icon-sm mr-2"></i> <span class="">Copy
                                                link</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="mb-3 tx-14">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus
                                minima delectus nemo unde quae recusandae assumenda.</p>
                            <img class="img-fluid" src="https://via.placeholder.com/513x342" alt="">
                        </div>
                        <div class="card-footer">
                            <div class="d-flex post-actions">
                                <a href="javascript:;" class="d-flex align-items-center text-muted mr-4">
                                    <i class="icon-md" data-feather="heart"></i>
                                    <p class="d-none d-md-block ml-2">Like</p>
                                </a>
                                <a href="javascript:;" class="d-flex align-items-center text-muted mr-4">
                                    <i class="icon-md" data-feather="message-square"></i>
                                    <p class="d-none d-md-block ml-2">Comment</p>
                                </a>
                                <a href="javascript:;" class="d-flex align-items-center text-muted">
                                    <i class="icon-md" data-feather="share"></i>
                                    <p class="d-none d-md-block ml-2">Share</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card rounded">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img class="img-xs rounded-circle" src="https://via.placeholder.com/37x37" alt="">
                                    <div class="ml-2">
                                        <p>Mike Popescu</p>
                                        <p class="tx-11 text-muted">5 min ago</p>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="dropdownMenuButton3"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg pb-3px" data-feather="more-horizontal"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                        <a class="dropdown-item d-flex align-items-center" href="#"><i
                                                data-feather="meh" class="icon-sm mr-2"></i> <span
                                                class="">Unfollow</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="#"><i
                                                data-feather="corner-right-up" class="icon-sm mr-2"></i> <span
                                                class="">Go to post</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="#"><i
                                                data-feather="share-2" class="icon-sm mr-2"></i> <span
                                                class="">Share</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="#"><i
                                                data-feather="copy" class="icon-sm mr-2"></i> <span class="">Copy
                                                link</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="mb-3 tx-14">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                            <img class="img-fluid" src="https://via.placeholder.com/513x342" alt="">
                        </div>
                        <div class="card-footer">
                            <div class="d-flex post-actions">
                                <a href="javascript:;" class="d-flex align-items-center text-muted mr-4">
                                    <i class="icon-md" data-feather="heart"></i>
                                    <p class="d-none d-md-block ml-2">Like</p>
                                </a>
                                <a href="javascript:;" class="d-flex align-items-center text-muted mr-4">
                                    <i class="icon-md" data-feather="message-square"></i>
                                    <p class="d-none d-md-block ml-2">Comment</p>
                                </a>
                                <a href="javascript:;" class="d-flex align-items-center text-muted">
                                    <i class="icon-md" data-feather="share"></i>
                                    <p class="d-none d-md-block ml-2">Share</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- middle wrapper end -->
        <!-- right wrapper start -->
        <div class="d-none d-xl-block col-xl-3 right-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="card rounded">
                        <div class="card-body">
                            <h6 class="card-title">latest photos</h6>
                            <div class="latest-photos">
                                <div class="row">
                                    <div class="col-md-4">
                                        <figure>
                                            <img class="img-fluid" src="https://via.placeholder.com/67x67" alt="">
                                        </figure>
                                    </div>
                                    <div class="col-md-4">
                                        <figure>
                                            <img class="img-fluid" src="https://via.placeholder.com/67x67" alt="">
                                        </figure>
                                    </div>
                                    <div class="col-md-4">
                                        <figure>
                                            <img class="img-fluid" src="https://via.placeholder.com/67x67" alt="">
                                        </figure>
                                    </div>
                                    <div class="col-md-4">
                                        <figure>
                                            <img class="img-fluid" src="https://via.placeholder.com/67x67" alt="">
                                        </figure>
                                    </div>
                                    <div class="col-md-4">
                                        <figure>
                                            <img class="img-fluid" src="https://via.placeholder.com/67x67" alt="">
                                        </figure>
                                    </div>
                                    <div class="col-md-4">
                                        <figure>
                                            <img class="img-fluid" src="https://via.placeholder.com/67x67" alt="">
                                        </figure>
                                    </div>
                                    <div class="col-md-4">
                                        <figure class="mb-0">
                                            <img class="img-fluid" src="https://via.placeholder.com/67x67" alt="">
                                        </figure>
                                    </div>
                                    <div class="col-md-4">
                                        <figure class="mb-0">
                                            <img class="img-fluid" src="https://via.placeholder.com/67x67" alt="">
                                        </figure>
                                    </div>
                                    <div class="col-md-4">
                                        <figure class="mb-0">
                                            <img class="img-fluid" src="https://via.placeholder.com/67x67" alt="">
                                        </figure>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 grid-margin">
                    <div class="card rounded">
                        <div class="card-body">
                            <h6 class="card-title">suggestions for you</h6>
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <div class="d-flex align-items-center hover-pointer">
                                    <img class="img-xs rounded-circle" src="https://via.placeholder.com/37x37" alt="">
                                    <div class="ml-2">
                                        <p>Mike Popescu</p>
                                        <p class="tx-11 text-muted">12 Mutual Friends</p>
                                    </div>
                                </div>
                                <button class="btn btn-icon"><i data-feather="user-plus" data-toggle="tooltip"
                                        title="Connect"></i></button>
                            </div>
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <div class="d-flex align-items-center hover-pointer">
                                    <img class="img-xs rounded-circle" src="https://via.placeholder.com/37x37" alt="">
                                    <div class="ml-2">
                                        <p>Mike Popescu</p>
                                        <p class="tx-11 text-muted">12 Mutual Friends</p>
                                    </div>
                                </div>
                                <button class="btn btn-icon"><i data-feather="user-plus" data-toggle="tooltip"
                                        title="Connect"></i></button>
                            </div>
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <div class="d-flex align-items-center hover-pointer">
                                    <img class="img-xs rounded-circle" src="https://via.placeholder.com/37x37" alt="">
                                    <div class="ml-2">
                                        <p>Mike Popescu</p>
                                        <p class="tx-11 text-muted">12 Mutual Friends</p>
                                    </div>
                                </div>
                                <button class="btn btn-icon"><i data-feather="user-plus" data-toggle="tooltip"
                                        title="Connect"></i></button>
                            </div>
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <div class="d-flex align-items-center hover-pointer">
                                    <img class="img-xs rounded-circle" src="https://via.placeholder.com/37x37" alt="">
                                    <div class="ml-2">
                                        <p>Mike Popescu</p>
                                        <p class="tx-11 text-muted">12 Mutual Friends</p>
                                    </div>
                                </div>
                                <button class="btn btn-icon"><i data-feather="user-plus" data-toggle="tooltip"
                                        title="Connect"></i></button>
                            </div>
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <div class="d-flex align-items-center hover-pointer">
                                    <img class="img-xs rounded-circle" src="https://via.placeholder.com/37x37" alt="">
                                    <div class="ml-2">
                                        <p>Mike Popescu</p>
                                        <p class="tx-11 text-muted">12 Mutual Friends</p>
                                    </div>
                                </div>
                                <button class="btn btn-icon"><i data-feather="user-plus" data-toggle="tooltip"
                                        title="Connect"></i></button>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center hover-pointer">
                                    <img class="img-xs rounded-circle" src="https://via.placeholder.com/37x37" alt="">
                                    <div class="ml-2">
                                        <p>Mike Popescu</p>
                                        <p class="tx-11 text-muted">12 Mutual Friends</p>
                                    </div>
                                </div>
                                <button class="btn btn-icon"><i data-feather="user-plus" data-toggle="tooltip"
                                        title="Connect"></i></button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- right wrapper end -->


        <!-- Button trigger modal -->

  <!-- Modal cover photo -->
  <div class="modal fade" id="coverModal" tabindex="-1" role="dialog" aria-labelledby="coverModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="coverModalLabel">Cover photo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('cover_photo.update') }}" method="post" enctype="multipart/form-data" id="mycover">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <input type="file" name="cover_photo" class="form-control">
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
  <!-- Modal profile photo-->
  <div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="photoModalLabel">Profile photo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('photo_photo.update') }}" method="post" enctype="multipart/form-data" id="myprofile">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <input type="file" name="photo_photo" class="form-control">
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
            @if(Session::has('success'))
                toastr.options =
                {
                    "closeButton" : true,
                    "progressBar" : true
                }
                    toastr.success("{{ session('success') }}");
            @endif
        </script>
            <script>

                $( "#mycover" ).validate({
                    rules: {
                        cover_photo: 'required',
                    }
                })

                $( "#myprofile" ).validate({
                    rules: {
                        photo_photo: 'required',
                    }
                })
            </script>
            
        @endsection
