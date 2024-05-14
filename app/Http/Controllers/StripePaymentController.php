<?php
    
namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Stripe as ModelsStripe;
use Illuminate\Http\Request;
use Session;
use Stripe;
use App\Models\Sslorder;
use App\Mail\InvoiceMail;
use App\Models\Billing;
use App\Models\Cart;
use App\Models\City;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Ship;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
     
class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        $data = session('data');

        $inside_charges = Delivery::where('delivery_type',1)->first()->amount;
        $outside_charges = Delivery::where('delivery_type',2)->first()->amount;
        $charge = 0;
        if($data['charge'] == 1){
            $charge = $inside_charges;
        }
        else{
            $charge = $outside_charges;
        }

        
        $check = '';
        if(empty($data['ship_check'])){
            $check = 0;
        }
        else{
            $check = 1;
        }
        
        $ship_country = 0;
        if(empty($data['ship_country'])){
            $ship_country = $data['country'];
        }
        else{
            $ship_country = $data['ship_country'];
        }
        
        $ship_city = 0;
        if(empty($data['ship_city'])){
            $ship_city = $data['city'];
        }
        else{
            $ship_city = $data['ship_city'];
        }
        
        // $ship_city = '';
        // if(empty($data['ship_city'])){
        //     $ship_city = 0;
        // }
        // else{
        //     $ship_city = 1;
        // }
        $total = $data['total']+$charge;

        $stripe_id = ModelsStripe::insertGetId([
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'sub_total' => $data['sub_total'],
            'discount' => $data['discount'],
            'charge' => $charge,
            'total' => $total,
            'address' => $data['address'],
            'country' => $data['country'],
            'city' => $data['city'],
            'zip' => $data['zip'],
            'company' => $data['company'],
            'notes' => $data['notes'],
            'ship_check' => $check,
            'ship_fname' => $data['ship_fname'],
            'ship_lname' => $data['ship_lname'],
            'ship_country' => $ship_country,
            'ship_city' => $ship_city,
            'ship_zip' => $data['ship_zip'],
            'ship_company' => $data['ship_company'],
            'ship_email' => $data['ship_email'],
            'ship_phone' => $data['ship_phone'],
            'ship_address' => $data['ship_address'],
            'payment_method' => $data['payment_method'],
            'customer_id' => $data['customer_id'],
            'coupon_id' => $data['coupon_id'],

        ]);
        return view('stripe',[
            'stripe_id'=>$stripe_id,
            'total'=>$total,
        ]);
    }
    
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {


        $data = ModelsStripe::find($request->stripe_id);


        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
        Stripe\Charge::create ([
                "amount" => 100 * $data->total,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com." 
        ]);
      
        $order_id = '#'.uniqid();
        $inside_charges = Delivery::where('delivery_type',1)->first()->amount;
        $outside_charges = Delivery::where('delivery_type',2)->first()->amount;
        $charge = 0;
        if($data->charge == 1){
            $charge = $inside_charges;
        }
        else{
            $charge = $outside_charges;
        }
        if ($data->ship_check == 1) {
            Order::insert([
                'order_id'=>$order_id,
                'customer_id'=>$data->customer_id,
                'sub_total'=>$data->sub_total,
                'discount'=>$data->discount,
                'delivery'=>$charge,
                'total'=>$data->total,
                'payment_method'=>$data->payment_method,
                'created_at'=>Carbon::now(),
            ]);
    
            Billing::insert([
                'order_id'=>$order_id,
                'customer_id'=>$data->customer_id,
                'fname'=>$data->fname,
                'lname'=>$data->lname,
                'country'=>$data->country,
                'city'=>$data->city,
                'zip'=>$data->zip,
                'company'=>$data->company,
                'email'=>$data->email,
                'phone'=>$data->phone,
                'address'=>$data->address,
                'notes'=>$data->notes,
                'created_at'=>Carbon::now(),
            ]);

            Ship::insert([
                'order_id'=>$order_id,
                'ship_fname'=>$data->ship_fname,
                'ship_lname'=>$data->ship_lname,
                'ship_country'=>$data->ship_country,
                'ship_city'=>$data->ship_city,
                'ship_zip'=>$data->ship_zip,
                'ship_company'=>$data->ship_company,
                'ship_email'=>$data->ship_email,
                'ship_phone'=>$data->ship_phone,
                'ship_address'=>$data->ship_address,
                'created_at'=>Carbon::now(),
            ]);
        }
        else{

            Order::insert([
                'order_id'=>$order_id,
                'customer_id'=>$data->customer_id,
                'sub_total'=>$data->sub_total,
                'discount'=>$data->discount,
                'delivery'=>$charge,
                'total'=>$data->total,
                'payment_method'=>$data->payment_method,
                'created_at'=>Carbon::now(),
            ]);
    
            Billing::insert([
                'order_id'=>$order_id,
                'customer_id'=>$data->customer_id,
                'fname'=>$data->fname,
                'lname'=>$data->lname,
                'country'=>$data->country,
                'city'=>$data->city,
                'zip'=>$data->zip,
                'company'=>$data->company,
                'email'=>$data->email,
                'phone'=>$data->phone,
                'address'=>$data->address,
                'notes'=>$data->notes,
                'created_at'=>Carbon::now(),
            ]);
            Ship::insert([
                'order_id'=>$order_id,
                'ship_fname'=>$data->fname,
                'ship_lname'=>$data->lname,
                'ship_country'=>$data->country,
                'ship_city'=>$data->city,
                'ship_zip'=>$data->zip,
                'ship_company'=>$data->company,
                'ship_email'=>$data->email,
                'ship_phone'=>$data->phone,
                'ship_address'=>$data->address,
                'created_at'=>Carbon::now(),
            ]);
        }
        $carts = Cart::where('customer_id',$data->customer_id)->get();
        foreach ($carts as $cart ) {
            OrderProduct::insert([
                'order_id'=>$order_id,
                'customer_id'=>$data->customer_id,
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
        if($data->discount){
            if($data->coupon_id == 1){
                Coupon::where('id',$data->coupon_id)->decrement('limit',1);
            }
            else{
                Coupon::where('id',$data->coupon_id)->decrement('limit',1);
            }
        } 
        Mail::to($data->email)->send(new InvoiceMail($order_id));
        return redirect()->route('order.success')->with('success',$order_id);
    }
}
