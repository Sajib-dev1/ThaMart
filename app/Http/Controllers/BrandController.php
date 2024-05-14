<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    function brand_list(){
        $brands = Brand::paginate(10);
        return view('backend.brand.brand_list',[
            'brands'=>$brands,
        ]);
    }

    function brand_store(Request $request){
        $request->validate([
            'brand_name'=>'unique:brands'
        ]);
        $photo = $request->image;
        $extension = $photo->extension();
        $file_name = Str::lower(str_replace(' ','-',$request->brand_name)) .'-'.uniqid().'.'.$extension;
        Image::make($photo)->resize(140,97)->save(public_path('uploads/brand/'.$file_name));
        Brand::insert([
            'brand_name'=>$request->brand_name,
            'image'=>$file_name,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('success','Brand added successfull');
    }

    function brand_update(Request $request,$id){
        if($request->image == null){
            Brand::find($id)->update([
                'brand_name'=>$request->brand_name,
                'updated_at'=>Carbon::now(),
            ]);
            return back()->with('success','Brand update successfull');
        }
        else{
            $user_info = Brand::find($id);
            $delete_form = public_path('uploads/brand/'.$user_info->image);
            unlink($delete_form);
    
            $photo = $request->image;
            $extension = $photo->extension();
            $file_name = Str::lower(str_replace(' ','-',$request->brand_name)) .'-'.uniqid().'.'.$extension;
            Image::make($photo)->resize(140,97)->save(public_path('uploads/brand/'.$file_name));
            Brand::find($id)->update([
                'brand_name'=>$request->brand_name,
                'image'=>$file_name,
                'updated_at'=>Carbon::now(),
            ]);
            return back()->with('success','Brand update successfull');
        }
    }

    function brand_delete($id){
        $user_info = Brand::find($id);
        $delete_form = public_path('uploads/brand/'.$user_info->image);
        unlink($delete_form);
        Brand::find($id)->delete();
        return back()->with('delete','Brand delete successfull');
    }
}
