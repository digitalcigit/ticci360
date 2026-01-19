<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    /**
     * Return a success JSON response.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @param  int  $code
     * @return JsonResponse
     */
    protected function success($data = null, string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'meta' => [
                'success' => true,
                'message' => $message,
                'timestamp' => now()->toIso8601String(),
            ],
        ], $code);
    }

    /**
     * Return a success JSON response for paginated resources.
     *
     * @param  \Illuminate\Http\Resources\Json\AnonymousResourceCollection  $collection
     * @param  string  $message
     * @param  int  $code
     * @return JsonResponse
     */
    protected function successPaginated($collection, string $message = 'Success', int $code = 200): JsonResponse
    {
        $paginator = $collection->resource;
        
        return response()->json([
            'data' => $collection->resolve(),
            'meta' => [
                'success' => true,
                'message' => $message,
                'timestamp' => now()->toIso8601String(),
                'pagination' => [
                    'total' => $paginator->total(),
                    'per_page' => $paginator->perPage(),
                    'current_page' => $paginator->currentPage(),
                    'last_page' => $paginator->lastPage(),
                    'total_pages' => $paginator->lastPage(),
                    'from' => $paginator->firstItem(),
                    'to' => $paginator->lastItem(),
                ],
            ],
        ], $code);
    }

    /**
     * Return an error JSON response.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  mixed  $errors
     * @return JsonResponse
     */
    protected function error(string $message, int $code = 400, $errors = null): JsonResponse
    {
        return response()->json([
            'data' => null,
            'meta' => [
                'success' => false,
                'message' => $message,
                'errors' => $errors,
                'timestamp' => now()->toIso8601String(),
            ],
        ], $code);
    }
}
