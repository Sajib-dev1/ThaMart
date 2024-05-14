<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ReturnProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class OrdersController extends Controller
{
    function cancel_order(){
        $orders = Order::where('customer_id',Auth::guard('customer')->id())->get();
        return view('admin.orders.orders',[
            'orders'=>$orders,
        ]);
    }

    function order_status_update(Request $request,$id){
        Order::find($id)->update([
            'status'=>$request->status,
        ]);
        return back();
    }

    function return_product($id){
        $detels = Order::find($id);
        return view('frontend.customer.return_product',[
            'detels'=>$detels,
        ]);
     }

    function return_product_store(Request $request){
        $request->validate([
            'resion'=>'required',
            'image'=>'required',
        ]);

        $photo = $request->image;
        $extension = $photo->extension();
        $file_name = uniqid().'.'.$extension;
        Image::make($photo)->save(public_path('uploads/return_product/'.$file_name));

        ReturnProduct::insert([
            'order_id'=>$request->order_id,
            'resion'=>$request->resion,
            'image'=>$file_name,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('success','Product return request successfull');
     }
}
