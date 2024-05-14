<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    function category_list(){
        $categories = Category::paginate(10);
        return view('backend.category.category_list',[
            'categories'=>$categories,
        ]);
    }

    function add_category(Request $request){
        $request->validate([
            'category'=>'unique:categories',
        ]);
        $photo = $request->icon;
        $extension = $photo->extension();
        $file_name = Str::lower(str_replace(' ','-',$request->category)) .'-'.uniqid().'.'.$extension;
        Image::make($photo)->resize(140,97)->save(public_path('uploads/category/'.$file_name));

        Category::insert([
            'category'=>$request->category,
            'icon'=>$file_name,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('success','Category store successfull');
    }

    function category_update(Request $request,$id){
        if($request->icon == null){
            $request->validate([
                'category'=>'required|unique:categories',
            ]);
            Category::find($id)->update([
                'category'=>$request->category,
                'updated_at'=>Carbon::now(),
            ]);
            return back()->with('success','Category update successfull');
        }
        else{
            $request->validate([
                'icon'=>'required',
            ]);
            $user_info = Category::find($id);
            $delete_form = public_path('uploads/category/'.$user_info->icon);
            unlink($delete_form);

            $photo = $request->icon;
            $extension = $photo->extension();
            $file_name = Str::lower(str_replace(' ','-',$request->category)) .'-'.uniqid().'.'.$extension;
            Image::make($photo)->resize(140,97)->save(public_path('uploads/category/'.$file_name));
    
            Category::find($id)->update([
                'category'=>$request->category,
                'icon'=>$file_name,
                'created_at'=>Carbon::now(),
            ]);
            return back()->with('success','Category update successfull'); 
        }
    }

    function category_soft_delete($id){
        Category::find($id)->delete();

        return back()->with('delete','Category soft delete successfull');
    }

    function trashed_category(){
        $categories = Category::onlyTrashed()->paginate(10);
        return view('backend.category.trashed_category',[
            'categories'=>$categories,
        ]);
    }

    function category_restore($id){
       Category::onlyTrashed()->find($id)->restore();
        return back()->with('success','Category restore successfull'); 
    }

    function category_delete($id){
        $cat_info = Category::onlyTrashed()->find($id);
        $delete_form = public_path('uploads/category/'.$cat_info->icon);
        unlink($delete_form);
        Subcategory::where('category_id',$id)->update([
            'category_id'=>1,
        ]);
        Category::onlyTrashed()->find($id)->forceDelete();

        return back()->with('delete','Category delete successfull');
    }
}
