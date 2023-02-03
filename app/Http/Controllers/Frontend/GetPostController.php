<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetPostController extends Controller
{

    //all posts
    public function index()
    {
        try {
            $posts=Posts::orderBy('id','asc')->get();
            if ($posts){
                return response()->json([
                    'success'=>true,
                    'posts'=>$posts,
                ]);
            }else{
                return response()->json([
                    'success'=>true,
                    'message'=>'some problem',
                ]);
            }
        }catch (\Exception $e){
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage(),
            ]);
        }
    }
    //most viewed
    public function viewPosts(){
        try {
            $posts=Posts::where('views','>',0)->orderBy('id','asc')->get();
            if ($posts){
                return response()->json([
                    'success'=>true,
                    'posts'=>$posts,
                ]);
            }else{
                return response()->json([
                    'success'=>true,
                    'message'=>'some problem',
                ]);
            }
        }catch (\Exception $e){
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage(),
            ]);
        }
    }
    //
    protected function getPostById($id)
    {
        try {
            $post=Posts::findOrFail($id);
            $post->views = $post->views + 1;
            $post->save();
            return response()->json([
                'success' => true,
                'posts' => $post
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function getPostByCategory($id)
    {
        try {
            $posts=Posts::where('cat_id',$id)->orderBy('id', 'asc')->get();
            return response()->json([
                'success' => true,
                'posts' => $posts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    //
    public function searchPost($title){
        try {
            $post=Posts::where('title','LIKE','%'.$title.'%')->get();
            if ($post){
                return response()->json([
                    'success'=>true,
                    'posts'=>$post,
                ]);
            }else{
                return response()->json([
                    'success'=>true,
                    'message'=>'some problem',
                ]);
            }
        }catch (\Exception $e){
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage(),
            ]);
        }
    }
}
