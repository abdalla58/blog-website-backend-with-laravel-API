<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;

class SubscribeController extends Controller
{

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
                'email'=>['required','email','unique:subscribes'],
            ]);
            if ($validation->fails()){
                return response()->json([
                    'success'=>false,
                    'message'=>$validation->errors()->all(),
                ]);
            }else{
                $result=Subscribe::create([
                    'email'=>$request->email,
                ]);
                if ($result){
                    return response()->json([
                        'success'=>true,
                        'message'=>'Subscribe successfully',
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
    public function subscribe(Request $request){
        try {
            $validation=Validator::make($request->all(),[
            'email'=>['required','email'],
        ]);
            if ($validation->fails()){
                return response()->json([
                    'success'=>false,
                    'message'=>$validation->errors()->all(),
                ]);
            }else{
                $subscribe=Subscribe::create([
                    'email'=>$request->email,
                ]);
                if ($subscribe){
                    return response()->json([
                        'success'=>true,
                        'message'=>'Subscribe successfully',
                    ]);
                }else{
                    return response()->json([
                        'success'=>false,
                        'message'=>'some problem',
                    ]);
                }
            }
        }catch (\Throwable $th){
            return response()->json([
                'success'=>false,
                'message'=>$th->getMessage(),
            ]);
        }
    }
}
