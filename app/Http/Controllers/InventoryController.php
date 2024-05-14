<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    function color(){
        $colors = Color::latest()->paginate(10);
        $sizes = Size::latest()->paginate(10);
        return view('backend.color.color',[
            'colors'=>$colors,
            'sizes'=>$sizes,
        ]);
    }

    function color_store(Request $request){
        $request->validate([
            'color_name'=>'unique:colors',
        ]);
        Color::insert([
            'color_name'=>$request->color_name,
            'color_code'=>$request->color_code,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('success','Color Added Successfull');
    }

    function size_store(Request $request){
        $request->validate([
            'size_name'=>'unique:sizes',
        ]);
        Size::insert([
            'size_name'=>$request->size_name,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('success','Size Added Successfull');
    }

    function inventory_list($id){
        $product_info = Product::find($id);
        $colors = Color::all();
        $sizes = Size::all();
        $inventories = Inventory::where('product_id',$id)->get();
        return view('backend.inventory.inventory_list',[
            'colors'=>$colors,
            'sizes'=>$sizes,
            'inventories'=>$inventories,
            'product_info'=>$product_info,
        ]);
    }

    function inventory_store(Request $request){
        if(Inventory::where('product_id',$request->product_id)->where('color_id',$request->color_id)->where('size_id',$request->size_id)->exists()){
            Inventory::where('product_id',$request->product_id)->where('color_id',$request->color_id)->where('size_id',$request->size_id)->increment('quantity',$request->quantity);

            return back()->with('success','Inventory Added Successfull');
        }
        else{
            Inventory::insert([
                'product_id'=>$request->product_id,
                'color_id'=>$request->color_id,
                'size_id'=>$request->size_id,
                'quantity'=>$request->quantity,
                'created_at'=>Carbon::now(),
            ]);
            return back()->with('success','Inventory Added Successfull');
        }
    }
}
