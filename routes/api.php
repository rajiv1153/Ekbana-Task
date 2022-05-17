<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyCategoryController;
use App\Http\Controllers\CompanyController;
// use App\Http\Middleware\ApiKeyChecker;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'API_KEY'], function () {
Route::post('/category',[CompanyCategoryController::class,'store']); //create category
Route::get('/category',[CompanyCategoryController::class,'index']); //view all

Route::prefix('/category')->group(function(){
    Route::get('/{id}',[CompanyCategoryController::class,'show']);  //show one
    Route::delete('/{id}',[CompanyCategoryController::class,'destroy']); //delete category
    Route::put('/{id}',[CompanyCategoryController::class,'update']); //update

});

Route::post('/company',[CompanyController::class,'store']); //company create
Route::get('/company',[CompanyController::class,'index']); // view all
Route::prefix('/company')->group(function(){
    Route::get('/{id}',[CompanyController::class,'show']); // view one 
    Route::put('/{id}',[CompanyController::class,'update']); //update company
    Route::delete('/{id}',[CompanyController::class,'destroy']); 

});

});
