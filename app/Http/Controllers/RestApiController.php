<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RestApiController extends Controller
{
    function api_cat(){
        $categories = file_get_contents("http://127.0.0.1:8000/api/category/api");
        $categories = json_decode($categories);
        return view('rest_api.api_cat',[
            'categories'=>$categories,
        ]);
    }

    function api_customer(){
        return view('rest_api.api_customer');
    }
}
