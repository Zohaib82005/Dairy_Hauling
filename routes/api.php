<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/viewLocation/{id}',function($id){
    $userLocation = User::select('latitude','longitude')
                    ->where('id',$id)
                    ->first();
    return $userLocation;
})->name('viewUser.location');
