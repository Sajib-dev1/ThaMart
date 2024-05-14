<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    function subcategory_list(){
        $subcategories = Subcategory::paginate(10);
        $categories = Category::all();
        return view('backend.subcategory.subcategory_list',[
            'subcategories'=>$subcategories,
            'categories'=>$categories,
        ]);
    }

    function subcategory_store(Request $request){
        $request->validate([
            'subcategory'=>'unique:subcategories'
        ]);
        Subcategory::insert([
            'category_id'=>$request->category_id,
            'subcategory'=>$request->subcategory,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('success','Subcategory store successfull'); 
    }

    function subcategory_update(Request $request,$id){
        Subcategory::find($id)->update([
            'category_id'=>$request->category_id,
            'subcategory'=>$request->subcategory,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('update','Subcategory update successfull');
    }

    function subcategory_soft_delete($id){
        Subcategory::find($id)->delete();
        return back()->with('delete','Subcategory delete successfull');
    }

    function trashed_subcategory(){
        $subcategories = Subcategory::onlyTrashed()->paginate(10);
        $categories = Category::all();
        return view('backend.subcategory.trashed_subcategory',[
            'categories'=>$categories,
            'subcategories'=>$subcategories,
        ]);
    }

    function subcategory_restore($id){
        Subcategory::onlyTrashed()->find($id)->restore();
        return back()->with('success','Subcategory restore successfull'); 
    }

    function subcategory_delete($id){
        Subcategory::onlyTrashed()->find($id)->forceDelete();

        return back()->with('delete','Subcategory delete successfull');
    }
}
