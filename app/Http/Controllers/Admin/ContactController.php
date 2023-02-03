<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $contacts=Contact::orderBy('id','asc')->get();
            if ($contacts){
                return response()->json([
                    'success'=>true,
                    'message'=>$contacts,
                ]);
            }else{
                return response()->json([
                    'success'=>false,
                    'message'=>'some problem',
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $contact=Contact::findOrFail($id)->delete();
            if ($contact){
                return response()->json([
                    'success'=>true,
                    'message'=>'Contact deleted successfully',
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
