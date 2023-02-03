<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use PHPUnit\Exception;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $comments=Comment::orderBy('id','asc')->get();
            if ($comments) {
                return response()->json([
                    'success' => true,
                    'message' => $comments
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'some problem'
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
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try{
            $result = Comment::find($id);
            if ($result) {
                $del = $result->delete();
                if ($del) {
                    return response()->json([
                        'success' => true,
                        'message' => 'comment deleted successfully'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'some problem'
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
