<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class DealController extends Controller
{
    function deal_of_day(){
        $deals = Deal::all();
        return view('backend.index.deal.deal_of_day',[
            'deals'=>$deals,
        ]);
    }

    function deal_store(Request $request){
        $photo = $request->photo;
        $extension = $photo->extension();
        $file_name = Str::lower(str_replace(' ','-',$request->name)) .'-'.uniqid().'.'.$extension;
        Image::make($photo)->resize(324,318)->save(public_path('uploads/deal/'.$file_name));

        Deal::insert([
            'name'=>$request->name,
            'price'=>$request->price,
            'discount'=>$request->discount,
            'after_discount'=>$request->price - $request->price*$request->discount/100,
            'photo'=>$file_name,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('success','deal store successfully');
    }
}
