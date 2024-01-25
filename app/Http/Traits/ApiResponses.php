<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponses
{
    protected function apiExceptionResponse(\Exception $e): JsonResponse
    {
        return response()->json(['message' => $e->getMessage(), 'status' => 500], 500);
    }

    protected function responseWithResult(string $result, string $message, int $status, ?array $data = []): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'result' => $result,
            'message' => $message,
        ], $status);
    }
}
