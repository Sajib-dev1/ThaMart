<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Color;
use App\Models\Deal;
use App\Models\Inventory;
use App\Models\NewOffer;
use App\Models\Offer;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Size;
use App\Models\SubscriberBan;
use App\Models\Tag;
use App\Models\Thumbnail;
use App\Models\Upcomming;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;

class FrontendController extends Controller
{
    function index(){
        $banners = Banner::latest()->get();
        $categories = Category::all();
        $upcomming_offer = Upcomming::first();
        $new_offer = NewOffer::first();
        $products = Product::where('status',1)->latest()->get();
        $offer_info = Offer::first();
        $deals = Deal::latest()->get();
        $subs_ban =  SubscriberBan::first();
        return view('frontend.index',[
            'banners'=>$banners,
            'categories'=>$categories,
            'upcomming_offer'=>$upcomming_offer,
            'new_offer'=>$new_offer,
            'products'=>$products,
            'offer_info'=>$offer_info,
            'deals'=>$deals,
            'subs_ban'=>$subs_ban,
        ]);
    }

    function product_single($slug){
        $product_id = Product::where('slug',$slug)->first()->id;
        $product_info = Product::find($product_id);
        $thumbnails = Thumbnail::where('product_id',$product_id)->get();
        $abable_colors = Inventory::where('product_id',$product_id)->groupBy('color_id')
        ->selectRaw('count(*) as total, color_id')
        ->get(); 
        $abable_sizes = Inventory::where('product_id',$product_id)->groupBy('size_id')
        ->selectRaw('count(*) as total, size_id')
        ->get();
        $related_products = Product::where('status',1)->where('category_id',$product_info->category_id)->where('id','!=',$product_id)->get();
        $reviews = OrderProduct::where('product_id',$product_id)->whereNotNull('review')->get();
        $total_review = OrderProduct::where('product_id',$product_id)->whereNotNull('review')->count();
        $total_star = OrderProduct::where('product_id',$product_id)->whereNotNull('review')->sum('star');

        //recent view
        $all = Cookie::get('recent-view');

        if (!$all) {
            $all = "[]";
        }
        $all_info = json_decode($all, true);
        $all_info = Arr::prepend($all_info, $product_id);
        $recent_product_id = json_encode($all_info);
        Cookie::queue('recent-view', $recent_product_id, 1000);
        return view('frontend.product_single',[
            'product_id'=>$product_id,
            'product_info'=>$product_info,
            'thumbnails'=>$thumbnails,
            'abable_colors'=>$abable_colors,
            'abable_sizes'=>$abable_sizes,
            'related_products'=>$related_products,
            'reviews'=>$reviews,
            'total_review'=>$total_review,
            'total_star'=>$total_star,
        ]);
    }

    function getsize(Request $request){
        $sizes = Inventory::where('product_id',$request->product_id)->where('color_id',$request->color_id)->get();
        $str = '';
        foreach ($sizes as $size) {
            if ($size->rel_to_size->size_name == 'NA') {
                $str .= '<li class="color"><input checked id="size'.$size->size_id.'" type="radio" class="size_id" name="size_id" value="'.$size->size_id.'">
                <label for="size'.$size->size_id.'">'.$size->rel_to_size->size_name.'</label>
            </li>';
            } else {
                $str .= '<li class="color"><input id="size'.$size->size_id.'" type="radio" name="size_id" class="size_id" value="'.$size->size_id.'">
                <label for="size'.$size->size_id.'">'.$size->rel_to_size->size_name.'</label>
            </li>';
            }
        }
        echo $str;
    }

    function getquantity(Request $request){
        $str = '';
        $quantity = Inventory::where('color_id',$request->color_id)->where('size_id',$request->size_id)->where('product_id',$request->product_id)->first()->quantity;
        if($quantity == 0){
            $str = '<p class="bg-danger p-2 d-inline text-white" style="border-radius: 5px;">Out Of Stack</p>';
        }
        else{
            $str = '<span>Stock:</span> '.$quantity.' Items In Stock';
        }
        echo $str;
    }

    function review_store(Request $request,$id){
        $request->validate([
            'stars'=>'required',
            'review'=>'required',
        ]);
        OrderProduct::where('customer_id',Auth::guard('customer')->id())->where('product_id',$id)->first()->update([
            'star'=>$request->stars,
            'review'=>$request->review,
            'updated_at'=>Carbon::now(),
        ]);
        return back()->with('success','Your review store successfully');
    }

    function shop(Request $request){
        $data = $request->all();

        $based = 'created_at';
        $type = 'DESC';
        if(!empty($data['sort']) && $data['sort'] != '' && $data['sort'] != 'undefined'){
            if($data['sort'] == 1){
                $based = 'after_discount';
                $type = 'ASC';
            }
            if($data['sort'] == 2){
                $based = 'after_discount';
                $type = 'DESC';
            }
            if($data['sort'] == 3){
                $based = 'product_name';
                $type = 'ASC';
            }
            if($data['sort'] == 4){
                $based = 'product_name';
                $type = 'DESC';
            }
        }
        
        $products = Product::where('status',1)->where(function($q) use ($data){
            $min = 0;
            $max = 0;
            if(!empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefined'){
                $min = $data['min'];
            }
            else{
                $min = 1;
            }
            if(!empty($data['max']) && $data['max'] != '' && $data['max'] != 'undefined'){
                $max = $data['max'];
            }
            else{
                $max = Product::max('price');
            }

            if(!empty($data['search_input']) && $data['search_input'] != '' && $data['search_input'] != 'undefined'){
                $q->where(function ($q) use ($data){
                    $q->where('product_name','like','%'.$data['search_input'].'%');
                    $q->orWhere('long_description','like','%'.$data['search_input'].'%');
                    $q->orWhere('additional_information','like','%'.$data['search_input'].'%');
                });
            }
            if(!empty($data['category_id']) && $data['category_id'] != '' && $data['category_id'] != 'undefined'){
                $q->where(function ($q) use ($data){
                    $q->where('category_id',$data['category_id']);
                });
            }
            if(!empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefined' || !empty($data['max']) && $data['max'] != '' && $data['max'] != 'undefined'){
                $q->whereBetween('price', [$min , $max]);
            }
            if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined'){
                $q->whereHas('rel_to_inventory',function($q) use ($data){
                    if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined'){
                        $q->whereHas('rel_to_color',function($q) use ($data){
                            $q->where('colors.id',$data['color_id']);
                        });
                    }
                });
            }
            if(!empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined'){
                $q->whereHas('rel_to_inventory',function($q) use ($data){
                    if(!empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined'){
                        $q->whereHas('rel_to_size',function($q) use ($data){
                            $q->where('sizes.id',$data['size_id']);
                        });
                    }
                });
            }
            if(!empty($data['tag']) && $data['tag'] != '' && $data['tag'] != 'undefined'){
                $q->where(function($q) use ($data){
                    $all = '';
                    foreach(Product::all() as $product){
                        $explode = explode(',',$product->tags);
                        if(in_array($data['tag'],$explode)){
                            $all .= $product->id.',';
                        }
                    }
                    $explode2 = explode(',',$all);
                    $q->find($explode2);
                });
            }
        })->orderBy( $based , $type)->get();
        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();
        $tags = Tag::all();
        return view('frontend.shop',[
            'products'=>$products,
            'categories'=>$categories,
            'colors'=>$colors,
            'sizes'=>$sizes,
            'tags'=>$tags,
        ]);
    }

    function resent_view(){
        $recent_info = json_decode(Cookie::get('recent-view'), true);
        if ($recent_info == Null) {
            $recent_info = [];
            $recent_viewed = array_unique($recent_info);
        } else {
            // $recent_viewed = array_reverse();
            $recent_viewed = array_unique($recent_info);
        }
        $recents = Product::find($recent_viewed);
        return view('frontend.resent_view',[
            'recents'=>$recents,
        ]);
    }
}
