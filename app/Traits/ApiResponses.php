<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponses
{
    protected function ok(string $message, array $data = []): JsonResponse
    {
        return $this->succcess($message, $data);
    }

    protected function succcess(string $message, array $data = [], int $code = 200): JsonResponse
    {
        return response()->json([
            'data'   => $data,
            'message'   => $message,
            'status'   => $code,
        ], $code);
    }

    protected function error($errorrs = [], int $code = 200): JsonResponse
    {
        if(is_string($errorrs)) {
            return response()->json([
                'message'   => $errorrs,
                'status'   => $code,
            ], $code);
        }

        return response()->json([
            'errorrs'  => $errorrs
        ]);
    }

    protected function notAuthorized($message)
    {
        return $this->error([
            'status' => 401,
            'message' => $message,
            'source' => '',
        ]);
    }
}
