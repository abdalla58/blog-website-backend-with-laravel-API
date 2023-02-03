<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use PHPUnit\Exception;

class SubscribeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $subscribes = Subscribe::orderBy('id', 'asc')->get();
            if ($subscribes) {
                return response()->json([
                    'success' => true,
                    'message' => $subscribes
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'some problems'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function getTotalSub()
    {
        try {
            $subscribes = Subscribe::count();
            return response()->json([
                'success' => true,
                'subscribes' => $subscribes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'subscribes' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            //$result = Subscribe::findOrFail($id);
            $result = Subscribe::find($id);
            if ($result) {
                $del=$result->delete();
                if ($del){
                    return response()->json([
                        'success' => true,
                        'message' => 'deleted Successfully'
                    ]);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'some problems'
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'not found'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
