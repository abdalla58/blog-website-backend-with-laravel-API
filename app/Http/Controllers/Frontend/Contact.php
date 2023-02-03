<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;
use App\Models\Contact as ModelContact;

class Contact extends Controller
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
                'name'=>['required','string','min:3','max:20'],
                'email'=>['required','string','min:3','max:20','email'],
                'subject'=>['required','string','min:4','max:20'],
                'message'=>['required','string','min:10'],
            ]);
            if ($validation->fails()){
                return response()->json([
                    'success'=>false,
                    'message'=>$validation->errors()->all(),
                ]);
            }else{
                $result=ModelContact::create([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'subject'=>$request->subject,
                    'message'=>$request->message,
                ]);
                if ($result){
                    return response()->json([
                        'success'=>true,
                        'message'=>'Contact Successfully Admin will response you via email',
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



}
