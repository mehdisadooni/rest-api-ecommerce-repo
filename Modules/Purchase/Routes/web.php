<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/payment/verify', function (Request $request) {
    $response = Http::post('http://localhost:8000/api/v1/payment/verify', [
        'token' => $request->token,
        'status' => $request->status
    ]);
    dd($response->json());
});

Route::get('/',function (){
  dd(route('auth.register'));
});
