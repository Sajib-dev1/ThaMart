<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use PDF;

class CustomerProfileController extends Controller
{
    function customer_profile(){
        return view('frontend.customer.customer_profile');
    }

    function customer_edit_profile(){
        return view('frontend.customer.customer_edit_profile');
    }

    function customer_update_profile(Request $request){
        $request->validate([
            'fname'=>'required',
            'lname'=>'required',
            'phone'=>'required',
            'zip'=>'required',
        ]);
        if($request->photo == ''){
            Customer::find(Auth::guard('customer')->id())->update([
                'fname'=>$request->fname,
                'lname'=>$request->lname,
                'phone'=>$request->phone,
                'zip'=>$request->zip,
                'updated_at'=>Carbon::now(),
            ]);
            return back()->with('success','Your profile update successfully');
        }
        else{
            if(Auth::guard('customer')->user()->photo == null){
                $photo = $request->photo;
                $extension = $photo->extension();
                $file_name = Auth::guard('customer')->id() .'.'.$extension;
                Image::make($photo)->save(public_path('uploads/customer/'.$file_name));

                Customer::find(Auth::guard('customer')->id())->update([
                    'fname'=>$request->fname,
                    'lname'=>$request->lname,
                    'phone'=>$request->phone,
                    'zip'=>$request->zip,
                    'photo'=>$file_name,
                    'updated_at'=>Carbon::now(),
                ]);
                return back()->with('success','Your profile update successfully');
            }
            else{
                $cat_info = Customer::find(Auth::guard('customer')->id());
                $delete_form = public_path('uploads/customer/'.$cat_info->photo);
                unlink($delete_form);

                $photo = $request->photo;
                $extension = $photo->extension();
                $file_name = Auth::guard('customer')->id() .'.'.$extension;
                Image::make($photo)->save(public_path('uploads/customer/'.$file_name));

                Customer::find(Auth::guard('customer')->id())->update([
                    'fname'=>$request->fname,
                    'lname'=>$request->lname,
                    'phone'=>$request->phone,
                    'zip'=>$request->zip,
                    'photo'=>$file_name,
                    'updated_at'=>Carbon::now(),
                ]);
                return back()->with('success','Your profile update successfully');
            }
        }
    }

    function cusomer_order(){
        $orders = Order::where('customer_id',Auth::guard('customer')->id())->get();
        return view('frontend.customer.cusomer_order',[
            'orders'=>$orders,
        ]);
    }

    function cusomer_wishlist(){
        $wishlists = Wishlist::where('customer_id',Auth::guard('customer')->id())->get();
        return view('frontend.customer.cusomer_wishlist',[
            'wishlists'=>$wishlists,
        ]);
    }

    function cusomer_password(){
        return view('frontend.customer.cusomer_password');
    }

    function customer_update_password(Request $request){
        $request->validate([
            'current_password'=>'required',
            'password'=>'required',
            'password'=>['required','confirmed',Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()],
            'password_confirmation'=>'required',
        ]);

        $cus = Customer::find(Auth::guard('customer')->id());
        if(Hash::check($request->current_password,$cus->password)){
            Customer::find(Auth::guard('customer')->id())->update([
                'password'=>bcrypt($request->password),
            ]);
            return back()->with('updated','Password Update Successfull'); 
        }
    }

    function customer_logout(){
        Auth::guard('customer')->logout();
        return redirect()->route('index');
    }

    function download_invoice($id){
        $orders = Order::find($id);
        $pdf = PDF::loadView('frontend.customer.invoicedownload',[
            'order_id'=>$orders->order_id,
        ]);
    
        return $pdf->stream('myInvoice.pdf');
    }
}
