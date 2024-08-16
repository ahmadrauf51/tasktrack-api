<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * Return a success response.
     *
     * @param  string  $message
     * @param  mixed  $data
     * @param  int  $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($message, $data = null, $statusCode = 200)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'statusCode' => $statusCode,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Return an error response.
     *
     * @param  string  $message
     * @param  int  $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function error($message, $statusCode = 400)
    {
        $response = [
            'success' => false,
            'message' => $message,
            'statusCode' => $statusCode,
        ];

        return response()->json($response, $statusCode);
    }
}

