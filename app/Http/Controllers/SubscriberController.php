<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Models\SubscriberBan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class SubscriberController extends Controller
{
    function subscriber_ban(){
        $subs_ban = SubscriberBan::first();
        return view('backend.index.subscribe.subscriber_ban',[
            'subs_ban'=>$subs_ban,
        ]);
    }

    function subscribe_update(Request $request,$id){
        if($request->image == null){
            SubscriberBan::find($id)->update([
                'title'=>$request->title,
                'updated_at'=>Carbon::now(),
            ]);
            return back()->with('updated','Offer update successfully');
        }
        else{
            $up_info = SubscriberBan::find($id);
            $delete_form = public_path('uploads/subscriber/'.$up_info->image);
            unlink($delete_form);

            $photo = $request->image;
            $extension = $photo->extension();
            $file_name = Str::lower(str_replace(' ','-',$request->title)) .'-'.uniqid().'.'.$extension;
            Image::make($photo)->save(public_path('uploads/subscriber/'.$file_name));

            SubscriberBan::find($id)->update([
                'title'=>$request->title,
                'image'=>$file_name,
                'updated_at'=>Carbon::now(),
            ]);
            return back()->with('updated','Offer update successfully');
        }
    }

    function subscriber_store(Request $request){
        $request->validate([
            'subscriber'=>'required|unique:subscribers',
        ]);
        Subscriber::insert([
            'subscriber'=>$request->subscriber,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('success','You Subscribe successfully');
    }
}
