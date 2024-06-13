<?php 

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\MessageBag;

trait HttpResponses
{
    public function success(string $message = null, string|int $status = 200, array|Model $data = [])
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public function error(string $message = null, string|int $status = 400, array|MessageBag $data = [])
    {
        throw new HttpResponseException(response()->json([
            'status' => $status,
            'message' => $message,
            'error' => $data,
        ], $status));
    }
}
