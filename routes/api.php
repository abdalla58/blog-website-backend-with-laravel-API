<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuth;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\SubscribeController as SAdmin;
use App\Http\Controllers\Admin\CommentController as CAdmin;
use App\Http\Controllers\Frontend\GetPostController;
use App\Http\Controllers\Frontend\Contact;
use App\Http\Controllers\Frontend\CommentController;
use App\Http\Controllers\Frontend\SubscribeController;
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
Route::prefix('/front')->group(function (){

    Route::get('/all-posts',[GetPostController::class,'index']);
    Route::get('/viewed-posts',[GetPostController::class,'viewPosts']);
    Route::get('/single-posts/{id}',[GetPostController::class,'getPostById']);
    Route::get('/category-posts/{id}',[GetPostController::class,'getPostByCategory']);
    Route::get('/search-posts/{title}',[GetPostController::class,'searchPost']);
    //contact
    Route::post('/contact',[Contact::class,'store']);
    Route::post('/subscribe',[SubscribeController::class,'store']);
    //comment
    Route::post('/comment/{id}',[CommentController::class,'store']);
    Route::get('comments',[CommentController::class,'getComments']);


});

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::middleware('auth:sanctum')->group(function (){
    Route::prefix('/admin')->group(function (){
        //admin
        Route::get('/admins',[AdminAuth::class,'admins']);
        Route::post('/logout',[AdminAuth::class,'logout']);
        //categories
        Route::get('/categories',[CategoryController::class,'index']);
        Route::get('/categories/{category_name}',[CategoryController::class,'show']);
        Route::post('/categories',[CategoryController::class,'store']);
        Route::put('/categories/{id}',[CategoryController::class,'edit']);
        Route::post('/categories/{id}',[CategoryController::class,'update']);
        Route::delete('/categories/{id}',[CategoryController::class,'destroy']);
        //posts
        Route::get('/posts',[PostController::class,'index']);
        Route::get('/posts/{title}',[PostController::class,'show']);
        Route::post('/posts',[PostController::class,'store']);
        Route::put('/posts/{id}',[PostController::class,'edit']);
        Route::post('/posts/{id}',[PostController::class,'update']);
        Route::delete('/posts/{id}',[PostController::class,'destroy']);
        //settings routes
        Route::get('/setting',[SettingController::class,'index']);
        Route::post('/setting/{id}',[SettingController::class,'update']);
        //contacts
        Route::get('/contacts',[ContactController::class,'index']);
        Route::delete('/contacts/{id}', [ContactController::class, 'destroy']);
        //subscribe
        Route::get('/subscribe',[SAdmin::class,'index']);
        Route::delete('/subscribe/{id}', [SAdmin::class, 'destroy']);
        //comment
        Route::get('/comments',[CAdmin::class,'index']);
        Route::delete('/comments/{id}', [CAdmin::class, 'destroy']);

    });
});
Route::post('login',[AdminAuth::class,'login']);

