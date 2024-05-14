<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    function cart_store(Request $request){
        if($request->cart_name == 1){
            if(Cart::where('customer_id',Auth::guard('customer')->id())->where('product_id',$request->product_id)->where('color_id',$request->color_id)->where('size_id',$request->size_id)->exists()){
                Cart::where('customer_id',Auth::guard('customer')->id())->where('product_id',$request->product_id)->where('color_id',$request->color_id)->where('size_id',$request->size_id)->increment('quantity',$request->quantity);
                return back();
            }
            $request->validate([
                'color_id'=>'required',
                'size_id'=>'required',
            ]);
            Cart::insert([
                'customer_id'=>Auth::guard('customer')->id(),
                'product_id'=>$request->product_id,
                'color_id'=>$request->color_id,
                'size_id'=>$request->size_id,
                'quantity'=>$request->quantity,
                'created_at'=>Carbon::now(),
            ]);
            return back()->with('success','Cart added successfully');
        }
        else{
            if(Wishlist::where('customer_id',Auth::guard('customer')->id())->where('product_id',$request->product_id)->exists()){
                return back(); 
            }
            else{
                Wishlist::insert([
                    'customer_id'=>Auth::guard('customer')->id(),
                    'product_id'=>$request->product_id,
                ]);
                return back()->with('success','Wishlist added successfully');
            }
        }
    }

    function wishlist_remove($id){
        Wishlist::find($id)->delete();
        return back();
    }

    function wishlist(){
        $wishlists = Wishlist::where('customer_id',Auth::guard('customer')->id())->get();
        return view('frontend.customer.wishlist',[
            'wishlists'=>$wishlists,
        ]);
    }

    function cart_remove($id){
        Cart::find($id)->delete();
        return back();
    }

    function cart(Request $request){
        $coupon = $request->coupon;
        $message = '';
        $amount = 0;
        $type = '';
        if ($coupon) {
            if(Coupon::where('coupon',$coupon)->exists()){
                if(Coupon::where('coupon',$coupon)->where('limit','!=',0)->exists()){
                    if(Carbon::now()->format('Y-m-d') <= Coupon::where('coupon',$coupon)->first()->validaty){
                        if(Coupon::where('coupon',$coupon)->where('limit', '!=',0)->where('status','!=',0 )->exists()){
                            $type = Coupon::where('coupon',$coupon)->first()->type;
                            $amount = Coupon::where('coupon',$coupon)->first()->amount;
                        }
                        else{
                            $message = 'Coupon Expired';
                            $amount = 0;
                        }
                    }
                    else{
                        $message = 'Coupon Expired';
                        $amount = 0;
                    }
                }
                else{
                    $message = 'Coupon Limit Expired';
                    $amount = 0;
                }
            }
            else{
                $message = 'Coupon does not exists';
                $amount = 0;
            }
        }

        $carts = Cart::where('customer_id',Auth::guard('customer')->id())->get();
        return view('frontend.customer.cart',[
            'carts'=>$carts,
            'message'=>$message,
            'amount'=>$amount,
            'type'=>$type,
        ]);
    }

    function cart_update(Request $request){
        foreach($request->quantity as $cart_id => $quantity){
            Cart::find($cart_id)->update([
                'quantity'=>$quantity,
            ]);
        }
        return back();
    }
}
