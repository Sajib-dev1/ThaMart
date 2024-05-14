<?php

use App\Http\Controllers\API\CategoryApiController;
use App\Http\Controllers\API\CustomerApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//========== Customer Authonication ============//
Route::post('/customer/regester',[CustomerApiController::class,'customer_register']);


//======= Category Api ==========//
Route::get('/category/api',[CategoryApiController::class,'get_category']);