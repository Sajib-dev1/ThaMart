<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Passreset;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PassreseatNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class PassresetController extends Controller
{
    function forgot_password(){
        return view('frontend.password_reset.forgot_password');
    }

    function password_reset_request(Request $request){
        $request->validate([
            'email'=>'required',
        ]);
        if(Customer::where('email',$request->email)->exists()){
           $customer = Customer::where('email',$request->email)->first();
           Passreset::where('customer_id',$customer->id)->delete();
           $info = Passreset::create([
            'customer_id'=>$customer->id,
            'token'=>uniqid(),
            'created_at'=>Carbon::now(),
           ]);
        //    Notification::send($customer, new PassResetNotification($info));
            Notification::send($customer, new PassreseatNotification($info));
           return back()->with('send',"we have send you a password resent link,on $request->email");
        }
        else{
            return back()->with('exists','Email does not exists');
        }
    }

    function password_reset_form($token){
        if (Passreset::where('token',$token)->exists()) {
            return view('frontend.password_reset.password_reset_form',[
                'token'=>$token,
            ]);
        }
        else{
            abort('404');
        }
    }

    function password_reset_form_succ(Request $request,$token){
        $request->validate([
            'password'=>['required','confirmed',Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()],
            'password_confirmation'=>'required',
        ]);
        $passreset = Passreset::where('token',$token)->first();

        Customer::find($passreset->customer_id)->update([
            'password'=>bcrypt($request->password),
        ]);
        Passreset::where('token',$token)->delete();
        return redirect()->route('customer.login')->with('reset','Password reset success!');
    }
}
