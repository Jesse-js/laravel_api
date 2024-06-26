<?php

namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\MessageBag;

trait HttpResponses
{
    public function success(
        string $message = null,
        string|int $status = 200,
        array|JsonResource $data = []
    ): JsonResponse {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public function error(
        string $message = null,
        string|int $status = 400,
        array|MessageBag $data = []
    ): JsonResponse {
        throw new HttpResponseException(response()->json([
            'status' => $status,
            'message' => $message,
            'error' => $data,
        ], $status));
    }
}
