<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;
use PDO;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $categories=Category::orderBy('id','desc')->get();
            if ($categories){
                return response()->json([
                   'success'=>true,
                   'categories'=>$categories
                ]);
            }
        }catch (Exception $e){
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage(),
            ]);
        }
    }
    public function getTotalCategory()
    {
        try {
            $categorys = Category::count();
            if ($categorys) {
                return response()->json([
                    'success' => true,
                    'categorys' => $categorys
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validation=Validator::make($request->all(),[
                'category_name'=>['required','string','min:10','max:20','unique:categories']
            ]);
            if ($validation->fails()){
                return response()->json([
                    'success'=>false,
                    'message'=>$validation->errors()->all(),
                ]);
            }else{
                $result=Category::create([
                    'category_name'=>$request->category_name,
                ]);
                if ($result){
                    return response()->json([
                        'success'=>true,
                        'message'=>'Category added successfully',
                    ]);
                }else{
                    return response()->json([
                        'success'=>true,
                        'message'=>'some problem',
                    ]);
                }
            }
        }catch (Exception $e){
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage(),
            ]);
        }
    }
    public function edit($id){
        try {
            $categories=Category::findOrFail($id);
            if ($categories){
                return response()->json([
                    'success'=>true,
                    'categories'=>$categories
                ]);
            }
        }catch (Exception $e){
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage(),
            ]);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function show($search){
        try {
            $categories=Category::where('category_name','LIKE','%'.$search.'%')->orderBy('id','desc')->get();
            if ($categories){
                return response()->json([
                    'success'=>true,
                    'categories'=>$categories
                ]);
            }
        }catch (Exception $e){
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $categories=Category::findOrFail($id);
            $validation=Validator::make($request->all(),[
                'category_name'=>['required','string','min:10','max:20','unique:categories']
            ]);
            if ($validation->fails()){
                return response()->json([
                    'success'=>false,
                    'message'=>$validation->errors()->all(),
                ]);
            }else{
                $categories->category_name=$request->category_name;
                $result =$categories->save();
                if ($result){
                    return response()->json([
                        'success'=>true,
                        'message'=>'Category updated successfully',
                    ]);
                }else{
                    return response()->json([
                        'success'=>true,
                        'message'=>'some problem',
                    ]);
                }
            }
        }catch (Exception $e){
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $result=Category::findOrFail($id)->delete();
            if ($result){
                return response()->json([
                    'success'=>true,
                    'message'=>'Category deleted successfully',
                ]);
            }else{
                return response()->json([
                    'success'=>true,
                    'message'=>'some problems',
                ]);
            }
        }catch (Exception $e){
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage(),
            ]);
        }
    }
}
