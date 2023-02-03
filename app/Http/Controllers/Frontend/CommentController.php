<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        try {
            $validation=Validator::make($request->all(),[
                'name' => ['required'],
                'email' => ['required', 'email'],
                'comment' => ['required'],
            ]);
            if ($validation->fails()){
                return response()->json([
                    'success'=>false,
                    'message'=>$validation->errors()->all(),
                ]);
            }else{
                $result=Comment::create([
                    'post_id' => $id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'comment' => $request->comment,
                ]);
                if ($result){
                    return response()->json([
                        'success'=>true,
                        'message'=>'Comment added successfully',
                    ]);
                }else{
                    return response()->json([
                        'success'=>false,
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
    public function getComments()
    {
        try {
            $comments = Comment::orderBy('id', 'desc')->get();
            return response()->json([
                'success' => true,
                'contects' => $comments
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'contects' => $e->getMessage(),
            ]);
        }
    }

}
