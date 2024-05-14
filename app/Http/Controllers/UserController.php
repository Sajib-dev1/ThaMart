<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Socile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    function user_profile(){
        $sociles = Socile::all();
        return view('backend.user.user_profile',[
            'sociles'=>$sociles,
        ]);
    }

    function user_profile_edit(){
        $countries = Country::all();
        $cities = City::all();
        $sociles = Socile::all();
        return view('backend.user.user_profile_edit',[
            'countries'=>$countries,
            'cities'=>$cities,
            'sociles'=>$sociles,
        ]);
    }

    function getusercity(Request $request){
        $str = '<option>Select City</option>';
        $cities = City::where('country_id',$request->country_id)->get();
    
        foreach ($cities as $city) {
            $str .= '<option value="'.$city->id.'">'.$city->name.'</option>';
        }
        echo $str;
    }

    function user_info_update(Request $request){
        User::find(Auth::id())->update([
            'about_info'=>$request->about_info,
            'name'=>$request->name,
            'profetion'=>$request->profetion,
            'country'=>$request->country,
            'city'=>$request->city,
            'address'=>$request->address,
            'web_url'=>$request->web_url,
            'updated_at'=>Carbon::now(),
        ]);
        return back()->with('update','User update successfully');
    }

    function user_password_update(Request $request){
        $user = User::find(Auth::id());
        if(Hash::check($request->old_password,$user->password)){
            User::find(Auth::id())->update([
                'password'=>bcrypt($request->password),
            ]);
            return back()->with('update','Password Update Successfull'); 
        }
        else{
            return back()->with('wrong','Password is wrong'); 
        }
    }

    function socile_store(Request $request){
        Socile::insert([
            'socile_icon'=>$request->socile_icon,
            'link'=>$request->link,
            'created_at'=>Carbon::now()
        ]);
        return back()->with('success','socile icon store successfull');
    }

    function socile_delete($id){
        Socile::find($id)->delete();
        return back()->with('delete','socile icon delete successfull');
    }

    function cover_photo_update(Request $request){

        if(Auth::user()->cover_photo == null){
            $photo = $request->cover_photo;
            $extension = $photo->extension();
            $file_name = uniqid().'.'.$extension;
            Image::make($photo)->resize(1148,272)->save(public_path('uploads/user/'.$file_name));
    
            User::find(Auth::id())->update([
                'cover_photo'=>$file_name,
                'updated_at'=>Carbon::now(),
            ]);
            return back()->with('success','cover photo update successfull');
        }
        else{
            $user_info = User::find(Auth::id());
            $delete_form = public_path('uploads/user/'.$user_info->cover_photo);
            unlink($delete_form);

            $photo = $request->cover_photo;
            $extension = $photo->extension();
            $file_name = uniqid().'.'.$extension;
            Image::make($photo)->resize(1148,272)->save(public_path('uploads/user/'.$file_name));
    
            User::find(Auth::id())->update([
                'cover_photo'=>$file_name,
                'updated_at'=>Carbon::now(),
            ]);
            return back()->with('success','cover photo update successfull');
        }
    }

    function photo_photo_update(Request $request){

        if(Auth::user()->photo_photo == null){
            $photo = $request->photo_photo;
            $extension = $photo->extension();
            $file_name = uniqid().'.'.$extension;
            Image::make($photo)->resize(100,100)->save(public_path('uploads/user/'.$file_name));
    
            User::find(Auth::id())->update([
                'photo_photo'=>$file_name,
                'updated_at'=>Carbon::now(),
            ]);
            return back()->with('success','profile photo update successfull');
        }
        else{
            $user_info = User::find(Auth::id());
            $delete_form = public_path('uploads/user/'.$user_info->photo_photo);
            unlink($delete_form);

            $photo = $request->photo_photo;
            $extension = $photo->extension();
            $file_name = uniqid().'.'.$extension;
            Image::make($photo)->resize(100,100)->save(public_path('uploads/user/'.$file_name));
    
            User::find(Auth::id())->update([
                'photo_photo'=>$file_name,
                'updated_at'=>Carbon::now(),
            ]);
            return back()->with('success','profile photo update successfull');
        }
    }
}
