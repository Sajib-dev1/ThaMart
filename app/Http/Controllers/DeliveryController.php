<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    function delivery(){
        $deliveries = Delivery::all();
        $delivery_inside = Delivery::where('delivery_type',1)->first()->id;
        $delivery_outside = Delivery::where('delivery_type',2)->first()->id;
        return view('backend.delivery.delivery',[
            'deliveries'=>$deliveries,
            'delivery_inside'=>$delivery_inside,
            'delivery_outside'=>$delivery_outside,
        ]);
    }

    function delivery_update(Request $request){
        $request->validate([
            'delivery_type'=>'required',
            'amount'=>'required',
        ]);
        if($request->delivery_type == 1){
            Delivery::find($request->delivery_inside_id)->update([
                'amount'=>$request->amount,
            ]);
            return back();
        }
        else{
            Delivery::find($request->delivery_outside_id)->update([
                'amount'=>$request->amount,
            ]);
            return back();
        }
    }
}
