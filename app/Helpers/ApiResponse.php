<?php

namespace App\Helpers;

class ApiResponse
{
    public static function success($data = null, $message = 'Success', $code = 200)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public static function error($message = 'Something went wrong.', $code = 500)
    {
        return response()->json([
            'message' => $message,
        ], $code);
    }

    public static function validationErrors($errors = [], $code = 422)
    {
        return response()->json([
            'message' => 'Validation Error',
            'errors' => $errors,
        ], $code);
    }
}
