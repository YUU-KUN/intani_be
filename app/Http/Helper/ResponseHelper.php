<?php
namespace App\Http\Helper;

class ResponseHelper {
    public static function success($message, $data = null) {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ]);
    }

    public static function error($message) {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], 400);
    }
}
