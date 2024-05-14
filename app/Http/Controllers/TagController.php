<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TagController extends Controller
{
    function tag(){
        $tags = Tag::paginate(10);
        return view('backend.tag.tag',[
            'tags'=>$tags,
        ]);
    }

    function tag_store(Request $request){

        $request->validate([
            'tag_name'=>'unique:tags'
        ]);
        Tag::insert([
            'tag_name'=>$request->tag_name,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('success','Tag add successfull'); 
    }

    function tag_delete($id){
        Tag::find($id)->delete();
        return back()->with('delete','Tag delete successfull');
    }
}
