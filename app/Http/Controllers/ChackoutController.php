<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\Billing;
use App\Models\Cart;
use App\Models\City;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Delivery;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Ship;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ChackoutController extends Controller
{
    function checkout(){
        $carts = Cart::where('customer_id',Auth::guard('customer')->id())->get();
        $delivery_inside = Delivery::where('delivery_type',1)->first()->amount;
        $delivery_outside = Delivery::where('delivery_type',2)->first()->amount;
        $countries = Country::all();
        return view('frontend.customer.checkout',[
            'carts'=>$carts,
            'delivery_inside'=>$delivery_inside,
            'delivery_outside'=>$delivery_outside,
            'countries'=>$countries,
        ]);
    }

    function getcheckoutcity(Request $request){
        $str = '<option>Select City</option>';
        $cities = City::where('country_id',$request->country_id)->get();
    
        foreach ($cities as $city) {
            $str .= '<option value="'.$city->id.'">'.$city->name.'</option>';
        }
        echo $str;
    }

    function checkout_store(Request $request){
        if($request->payment_method == 1){
            $order_id = '#'.uniqid();
            $inside_charges = Delivery::where('delivery_type',1)->first()->amount;
            $outside_charges = Delivery::where('delivery_type',2)->first()->amount;
            $charge = 0;
            if($request->charge == 1){
                $charge = $inside_charges;
            }
            else{
                $charge = $outside_charges;
            }
            if ($request->ship_check == 1) {
                $request->validate([
                    'fname'=>'required',
                    'country'=>'required',
                    'city'=>'required',
                    'zip'=>'required',
                    'email'=>'required',
                    'phone'=>'required',
                    'address'=>'required',
                    'ship_fname'=>'required',
                    'ship_country'=>'required',
                    'ship_city'=>'required',
                    'ship_zip'=>'required',
                    'ship_phone'=>'required',
                    'ship_address'=>'required',
                    'charge'=>'required',
                ]);
                Order::insert([
                    'order_id'=>$order_id,
                    'customer_id'=>$request->customer_id,
                    'sub_total'=>$request->sub_total,
                    'discount'=>$request->discount,
                    'delivery'=>$charge,
                    'total'=>$request->total+$charge,
                    'payment_method'=>$request->payment_method,
                    'created_at'=>Carbon::now(),
                ]);
        
                Billing::insert([
                    'order_id'=>$order_id,
                    'customer_id'=>$request->customer_id,
                    'fname'=>$request->fname,
                    'lname'=>$request->lname,
                    'country'=>$request->country,
                    'city'=>$request->city,
                    'zip'=>$request->zip,
                    'company'=>$request->company,
                    'email'=>$request->email,
                    'phone'=>$request->phone,
                    'address'=>$request->address,
                    'notes'=>$request->notes,
                    'created_at'=>Carbon::now(),
                ]);
    
                Ship::insert([
                    'order_id'=>$order_id,
                    'ship_fname'=>$request->ship_fname,
                    'ship_lname'=>$request->ship_lname,
                    'ship_country'=>$request->ship_country,
                    'ship_city'=>$request->ship_city,
                    'ship_zip'=>$request->ship_zip,
                    'ship_company'=>$request->ship_company,
                    'ship_email'=>$request->ship_email,
                    'ship_phone'=>$request->ship_phone,
                    'ship_address'=>$request->ship_address,
                    'created_at'=>Carbon::now(),
                ]);
            }
            else{
                $request->validate([
                    'fname'=>'required',
                    'country'=>'required',
                    'city'=>'required',
                    'zip'=>'required',
                    'email'=>'required',
                    'phone'=>'required',
                    'address'=>'required',
                    'charge'=>'required',
                ]);

                Order::insert([
                    'order_id'=>$order_id,
                    'customer_id'=>$request->customer_id,
                    'sub_total'=>$request->sub_total,
                    'discount'=>$request->discount,
                    'delivery'=>$charge,
                    'total'=>$request->total,
                    'payment_method'=>$request->payment_method,
                    'created_at'=>Carbon::now(),
                ]);
        
                Billing::insert([
                    'order_id'=>$order_id,
                    'customer_id'=>$request->customer_id,
                    'fname'=>$request->fname,
                    'lname'=>$request->lname,
                    'country'=>$request->country,
                    'city'=>$request->city,
                    'zip'=>$request->zip,
                    'company'=>$request->company,
                    'email'=>$request->email,
                    'phone'=>$request->phone,
                    'address'=>$request->address,
                    'notes'=>$request->notes,
                    'created_at'=>Carbon::now(),
                ]);
                Ship::insert([
                    'order_id'=>$order_id,
                    'ship_fname'=>$request->fname,
                    'ship_lname'=>$request->lname,
                    'ship_country'=>$request->country,
                    'ship_city'=>$request->city,
                    'ship_zip'=>$request->zip,
                    'ship_company'=>$request->company,
                    'ship_email'=>$request->email,
                    'ship_phone'=>$request->phone,
                    'ship_address'=>$request->address,
                    'created_at'=>Carbon::now(),
                ]);
            }
            $carts = Cart::where('customer_id',$request->customer_id)->get();
            foreach ($carts as $cart ) {
                OrderProduct::insert([
                    'order_id'=>$order_id,
                    'customer_id'=>$request->customer_id,
                    'product_id'=>$cart->product_id,
                    'price'=>$cart->rel_to_product->after_discount,
                    'color_id'=>$cart->color_id,
                    'size_id'=>$cart->size_id,
                    'quantity'=>$cart->quantity,
                    'created_at'=>Carbon::now(),
                ]);
                Cart::find($cart->id)->delete();
                Inventory::where('product_id',$cart->product_id)->where('color_id',$cart->color_id)->where('size_id',$cart->size_id)->decrement('quantity',$cart->quantity);
            }
            if($request->discount){
                if($request->coupon_id == 1){
                    Coupon::where('id',$request->coupon_id)->decrement('limit',1);
                }
                else{
                    Coupon::where('id',$request->coupon_id)->decrement('limit',1);
                }
            } 

            $to_tal = $request->total+$charge;

                $url = "http://bulksmsbd.net/api/smsapi";
                $api_key = " DOF7wZ47pXaRekYi89QU";
                $senderid = "8809617618497";
                $number = "$request->phone";
                $message = "Congratulation your order has been placed Total amount is $to_tal Taka ";
             
                $data = [
                    "api_key" => $api_key,
                    "senderid" => $senderid,
                    "number" => $number,
                    "message" => $message
                ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec($ch);
                curl_close($ch);
                return $response;






            Mail::to($request->email)->send(new InvoiceMail($order_id));
            return redirect()->route('order.success')->with('success',$order_id);
        }
        elseif ($request->payment_method == 2) {
            $data = $request->all();
            // if ($request->ship_check == 1) {
            //     return $request->all();
            // }
            // else{
            //     echo 'ship not check';
            // }
            return redirect()->route('sslpay')->with('data',$data);
        }
        else{
            if ($request->ship_check == 1) {
                echo 'ship check';
            }
            else{
                echo 'ship not check';
            }
            $data = $request->all();
            return redirect()->route('stripe')->with('data',$data);
        }
    }

    function order_success(){
        return view('frontend.customer.order_success');
    }
}
