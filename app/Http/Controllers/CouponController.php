<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    function coupon(){
        $coupons = Coupon::all();
        return view('backend.coupon.coupon',[
            'coupons'=>$coupons,
        ]);
    }

    function coupon_store(Request $request){
        $request->validate([
            'coupon'=>'required',
            'type'=>'required',
            'amount'=>'required',
            'validaty'=>'required',
            'limit'=>'required',
        ]);
        Coupon::insert([
            'coupon'=>$request->coupon,
            'type'=>$request->type,
            'amount'=>$request->amount,
            'validaty'=>$request->validaty,
            'limit'=>$request->limit,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('success','Coupon added successfull');
    }

    function getcouponctstatus(Request $request){
        Coupon::find($request->coupon_id)->update([
            'status'=>$request->status,
            'updated_at'=>Carbon::now(),
        ]);
    }

    function coupon_delete($id){
        Coupon::find($id)->delete();
        return back()->with('delete','Coupon delete successfully');
    }
}
