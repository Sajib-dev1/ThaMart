<style>
    .card-header{
        padding: 0;
    }
    .banner_card{
        width: 100%;
        height: 75px;
        position: relative;
    }
    .profile_card{
        position: absolute;
        bottom: -50px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 111;
    }
    .profile_card img{
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
    }
    .banner-name h3{
        padding-top: 70px;
        line-height: 10px;
    }
    .banner-name{
        border-bottom: 1px solid #ddd;
        width: 250px;
        margin: 0 auto;
    }
    .customer-menu ul li:hover{
        border-left: 3px solid #0da487;
        background: rgb(208 236 232);
    }
    .profile_list{
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        margin-top: 20px;
    }
    .item_list{
        width: 210px !important;
    }
    .cus input:focus{
        background: linear-gradient(#24a49e,#c69771);
        box-shadow: none;
        color: #fff;
    }
</style>
<div class="col-lg-3">
    <div class="card">
        <div class="card-header">
            <div class="banner_card" style="background: url({{ asset('uploads/customer/costomer_profile.jpg') }})">
                <div class="profile_card">
                    @if (Auth::guard('customer')->user()->photo == null)
                        <img src="{{ Avatar::create(Auth::guard('customer')->user()->fname.' '.Auth::guard('customer')->user()->lname)->toBase64() }}" />
                    @else
                        <img src="{{ asset('uploads/customer') }}/{{ Auth::guard('customer')->user()->photo }}" alt="">
                    @endif
                </div>
            </div>
            <div class="banner-name">
                <h3 class="text-center">{{ Auth::guard('customer')->user()->fname.' '.Auth::guard('customer')->user()->lname }}</h3>
                <p class="text-center">{{ Auth::guard('customer')->user()->email }}</p>
            </div>

            <div class="customer-menu my-3">
                <ul>
                    <li class="p-2 ps-5"><a  href="{{ route('customer.profile') }}" style="color: #258004"><i class="fa fa-user pe-3" aria-hidden="true"></i>Profile</a></li>
                    <li class="p-2 ps-5"><a  href="{{ route('cusomer.order') }}" style="color: #258004"><i class="fa fa-shopping-bag pe-2" aria-hidden="true"></i> My Order</a></li>
                    <li class="p-2 ps-5"><a  href="{{ route('cusomer.wishlist') }}" style="color: #258004"><i class="fa fa-heart pe-2" aria-hidden="true"></i></i> Wishlist</a></li>
                    <li class="p-2 ps-5"><a  href="#" style="color: #258004"><i class="fa fa-cog pe-2" aria-hidden="true"></i> Satting</a></li>
                    <li class="p-2 ps-5"><a  href="{{ route('cusomer.password') }}" style="color: #258004"><i class="fa fa-lock pe-2" aria-hidden="true"></i></i>Change Password</a></li>
                    <li class="p-2 ps-5"><a  href="{{ route('customer.logout') }}" style="color: #258004"><i class="fa fa-sign-out pe-2" aria-hidden="true"></i> Log Out</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>