<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class CustomerApiController extends Controller
{
    public function customer_register(Request $request){
        $validator = Validator::make($request->all(),[
            'fname'=>'required',
            'lname'=>'required',
            'email'=>'required',
            'password'=>['required','confirmed',Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()],
            'password_confirmation'=>'required',
            'captcha' => 'required|captcha'
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }

        $customers = Customer::create([
            'fname'=>$request->fname,
            'lname'=>$request->lname,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);

        $token = $customers->createToken('hodaitoken')->plainTextToken;

        $response = [
            'customers'=>$customers,
            'token'=>$token,
        ];

        return response()->json($response);
    }
}
