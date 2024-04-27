<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\AuthControllerAdmin;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\User\AuthControllerUser;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware'=>['api','checkpassword'],
],
function(){
     Route::post('categories',[CategoriesController::class,'index']);
     Route::post('getCategory',[CategoriesController::class,'getCategory']);
     Route::post('changeStatus',[CategoriesController::class,'changeStatus']);

     Route::group(['prefix'=>'admin',
],
function(){
     Route::post('login',[AuthControllerAdmin::class,'login']);
     Route::post('logout',[AuthControllerAdmin::class,'logout'])->middleware('assignguard:admin_api');
});


Route::group(['prefix'=>'user',
],
function(){
     Route::post('login',[AuthControllerUser::class,'login']);
});

Route::group(['prefix'=>'user','middleware'=>'assignguard:user_api',
],
function(){
   Route::post('profile',function(){
     return Auth::user();
   });
});

});


Route::group(['middleware'=>['api','checkpassword','checkadmintoken:admin_api'],
],
function(){
     Route::get('offers',[CategoriesController::class,'index']);
});