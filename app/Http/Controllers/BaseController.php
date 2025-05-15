<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BaseController extends Controller
{
    /**
     * return success response.
     *
     * @param mixed $result
     * @param mixed $message
     */
    public function sendResponse($result, $message): JsonResponse
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @param mixed $error
     * @param mixed $errorMessages
     * @param mixed $code
     */
    public function sendError($error, $errorMessages = [], $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
