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

    protected function error(string $message, int $code): JsonResponse
    {
        return response()->json([
            'message'   => $message,
            'status'   => $code,
        ], $code);
    }
}
