<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $posts=Posts::orderBy('id','asc')->with('categories')->get();
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
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validation=Validator::make($request->all(),[
                'title'=>['required','string','min:5','max:100','unique:posts'],
                'description'=>['required','string','min:5','max:1000'],
                'cat_id'=>['required'],
                'image'=>['required'],
            ]);
            if ($validation->fails()){
                return response()->json([
                    'success'=>false,
                    'message'=>$validation->errors()->all(),
                ]);
            }else{
                $filename="";
                if ($request->file('image')){
                    $filename=$request->file('image')->store('posts','public');
                }else{
                    $filename="null";
                }
                $post=Posts::create([
                    'title'=>$request->title,
                    'description'=>$request->description,
                    'cat_id'=>$request->cat_id,
                    'image'=>$filename,
                    'views'=>0,
                ]);
                if ($post){
                    return response()->json([
                        'success'=>true,
                        'message'=>'Post added successfully',
                    ]);
                }else{
                    return response()->json([
                        'success'=>false,
                        'message'=>'some problems',
                    ]);
                }
            }
        }catch (\Exception $e){
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function show($title)
    {
        try {
            $posts=Posts::where('title','LIKE','%'.$title.'%')->orderBy('id')->with('categories')->get();
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $posts=Posts::findOrFail($id);
            $validation=Validator::make($request->all(),[
                'title'=>['required','string','min:5','max:100','unique:posts'],
                'description'=>['required','string','min:5','max:1000'],
                'cat_id'=>['required'],
            ]);
            if ($validation->fails()){
                return response()->json([
                    'success'=>false,
                    'message'=>$validation->errors()->all(),
                ]);
            }else{
                $filename = "";
                $destination = public_path('storage\\' . $posts->image);
                if ($request->file('new_image')) {
                    if (File::exists($destination)) {
                        File::delete($destination);
                    }
                    $filename = $request->file('new_image')->store('posts', 'public');
                } else {
                    $filename = $request->old_image;
                }
                $posts->title=$request->title;
                $posts->description=$request->description;
                $posts->cat_id=$request->cat_id;
                $posts->image=$filename;
                $result=$posts->save();
                if ($result){
                    return response()->json([
                        'success'=>true,
                        'message'=>'Post updated successfully',
                    ]);
                }else{
                    return response()->json([
                        'success'=>true,
                        'message'=>'some problem',
                    ]);
                }
            }
        }catch (\Exception $e){
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $posts = Posts::findOrFail($id);
            $destination = public_path('storage\\' . $posts->image);

            if (File::exists($destination)) {
                File::delete($destination);
            }

            $result = $posts->delete();
            if ($result){
                return response()->json([
                    'success'=>true,
                    'message'=>'post deleted successfully',
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
    public function edit($id){
        try {
            $post=Posts::findOrFail($id);
            if ($post){
                return response()->json([
                    'success'=>true,
                    'Posts'=>$post,
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
