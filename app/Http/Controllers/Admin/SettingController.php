<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $settings=Setting::findOrFail(1);
            if ($settings){
                return response()->json([
                    'success'=>true,
                    'message'=>$settings,
                ]);
            }else{
                return response()->json([
                    'success'=>false,
                    'message'=>'Some problem',
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
     * @return \Illuminate\Http\Response
     */
//    public function store(Request $request)
//    {
//        //
//    }
//
//    /**
//     * Display the specified resource.
//     *
//     * @param  \App\Models\Setting  $setting
//     * @return \Illuminate\Http\Response
//     */
//    public function show(Setting $setting)
//    {
//        //
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validation=Validator::make($request->all(),[
                'header_logo' => ['required'],
                'footer_logo' => ['required'],
                'footer_desc' => ['required'],
                'email' => ['required', 'email'],
                'phone' => ['required'],
                'address' => ['required'],
                'facebook' => ['required'],
                'instagram' => ['required'],
                'youtube' => ['required'],
                'about_title' => ['required'],
                'about_desc' => ['required'],
            ]);
            if ($validation->fails()){
                return response()->json([
                    'success' => false,
                    'message' => $validation->errors()->all(),
                ]);
            }else{
                $result=Setting::findOrFail($id)->update([
                    'header_logo' => $request->header_logo,
                    'footer_logo' => $request->footer_logo,
                    'footer_desc' => $request->footer_desc,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'facebook' => $request->facebook,
                    'instagram' => $request->instagram,
                    'youtube' => $request->youtube,
                    'about_title' => $request->about_title,
                    'about_desc' => $request->about_desc,
                ]);
                if ($result){
                    return response()->json([
                        'success'=>true,
                        'message'=>"Setting Update Successfully",
                    ]);
                }else{
                    return response()->json([
                        'success'=>false,
                        'message'=>'Some problem',
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
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
//    public function destroy(Setting $setting)
//    {
//        //
//    }
}
