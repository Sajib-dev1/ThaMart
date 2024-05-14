<?php

namespace App\Http\Controllers;

use App\Models\NewOffer;
use App\Models\Offer;
use App\Models\Upcomming;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class OfferController extends Controller
{
    function offer(){
        $upcomming_offer = Upcomming::first();
        $new_offer = NewOffer::first();
        $offer_info = Offer::first();
        return view('backend.index.offer.upcommin_offer',[
            'upcomming_offer'=>$upcomming_offer,
            'new_offer'=>$new_offer,
            'offer_info'=>$offer_info,
        ]);
    }

    function upcomming_update(Request $request){
        if($request->image == null){
            $request->validate([
                'name'=>'required',
                'price'=>'required',
            ]);
            Upcomming::find($request->id)->update([
                'name'=>$request->name,
                'price'=>$request->price,
                'discount'=>$request->discount,
                'after_discount'=>$request->price - $request->price*$request->discount/100,
                'date'=>$request->date,
                'updated_at'=>Carbon::now(),
            ]);
            return back()->with('updated','Offer update successfully');
        }
        else{
            $up_info = Upcomming::find($request->id);
            $delete_form = public_path('uploads/offer/'.$up_info->image);
            unlink($delete_form);

            $photo = $request->image;
            $extension = $photo->extension();
            $file_name = Str::lower(str_replace(' ','-',$request->name)) .'-'.uniqid().'.'.$extension;
            Image::make($photo)->save(public_path('uploads/offer/'.$file_name));

            Upcomming::find($request->id)->update([
                'name'=>$request->name,
                'price'=>$request->price,
                'discount'=>$request->discount,
                'after_discount'=>$request->price - $request->price*$request->discount/100,
                'date'=>$request->date,
                'image'=>$file_name,
                'updated_at'=>Carbon::now(),
            ]);
            return back()->with('updated','Offer update successfully');
        }
    }

    function newoffer_update(Request $request,$id){
        if($request->image == null){
            $request->validate([
                'title'=>'required',
                'sub_title'=>'required',
            ]);
            NewOffer::find($id)->update([
                'title'=>$request->title,
                'sub_title'=>$request->sub_title,
                'updated_at'=>Carbon::now(),
            ]);
            return back()->with('updated','Offer update successfully');
        }
        else{
            $request->validate([
                'title'=>'required',
                'sub_title'=>'required',
                'image'=>'required',
            ]);
            $up_info = NewOffer::find($id);
            $delete_form = public_path('uploads/offer/'.$up_info->image);
            unlink($delete_form);

            $photo = $request->image;
            $extension = $photo->extension();
            $file_name = Str::lower(str_replace(' ','-',$request->title)) .'-'.uniqid().'.'.$extension;
            Image::make($photo)->save(public_path('uploads/offer/'.$file_name));

            NewOffer::find($id)->update([
                'title'=>$request->title,
                'sub_title'=>$request->sub_title,
                'image'=>$file_name,
                'updated_at'=>Carbon::now(),
            ]);
            return back()->with('updated','Offer update successfully');
        }
    }

    function offer_update(Request $request,$id){
        if($request->image == null){
            $request->validate([
                'title'=>'required',
                'sub_title'=>'required',
            ]);
            Offer::find($id)->update([
                'title'=>$request->title,
                'sub_title'=>$request->sub_title,
                'updated_at'=>Carbon::now(),
            ]);
            return back()->with('updated','Offer update successfully');
        }
        else{
            $request->validate([
                'title'=>'required',
                'sub_title'=>'required',
                'image'=>'required',
            ]);
            $up_info = Offer::find($id);
            $delete_form = public_path('uploads/offer/'.$up_info->image);
            unlink($delete_form);

            $photo = $request->image;
            $extension = $photo->extension();
            $file_name = Str::lower(str_replace(' ','-',$request->title)) .'-'.uniqid().'.'.$extension;
            Image::make($photo)->save(public_path('uploads/offer/'.$file_name));

            Offer::find($id)->update([
                'title'=>$request->title,
                'sub_title'=>$request->sub_title,
                'image'=>$file_name,
                'updated_at'=>Carbon::now(),
            ]);
            return back()->with('updated','Offer update successfully');
        }
    }
}
