<?php

namespace App\Libraries;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * Return a custom response with title
     *
     * @param ServiceResponse $serviceResponse
     * @return JsonResponse
     */
    public static function customResponse(ServiceResponse $serviceResponse): JsonResponse
    {
        $response = [
            'success' => $serviceResponse->isSuccess,
            'status' => $serviceResponse->statusCode,
            'message' => $serviceResponse->message
        ];

        if ($serviceResponse->data !== null) {
            $response['data'] = $serviceResponse->data;
        }

        return response()->json($response, $serviceResponse->statusCode);
    }

    public static function errorResponse($message, $status = 500, $errors = null, $data = null, $isSuccess = false): JsonResponse
    {
        $response = [
            'success' => $isSuccess,
            'status' => $status,
            'message' => $message,
            'errors' => $errors,
            'data' => $data
        ];

        return response()->json($response, $status);
    }
} 