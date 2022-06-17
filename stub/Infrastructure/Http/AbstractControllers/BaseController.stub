<?php

namespace App\Infrastructure\Http\AbstractControllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Handling ApiResponse.
     *
     * @param boolean $success
     * @param mixed $data
     * @param $messages
     * @param int $status
     * @return JsonResponse
     */
    public function apiOutResponse($success, $data, $messages, $status = 200) : JsonResponse
    {
        $response = [
            'success' => $success,
            'data'    => $data,
            'message' => $messages,
            'status'  => $status,
        ];

        return response()->json($response, $status);
    }

    /**
     * Handeling ApiResponse.
     *
     * @param  mixed   $data
     * @param  boolean $success
     * @param  integer $statusCode
     * @param  array   $errors
     * @return JsonResponse
     */
    public function apiResponse($data, bool $success = true, int $statusCode = 200, array $errors = []) : JsonResponse
    {
        return response()->json([
            'status' => $statusCode,
            'success' => $success,
            'payload' => $data,
            'errors' => $errors,
        ], $statusCode);
    }
}
