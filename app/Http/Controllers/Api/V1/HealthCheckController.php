<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class HealthCheckController extends ApiController
{
    /**
     * Check the health of the application.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $services = [
            'database' => $this->checkDatabase(),
            'redis' => $this->checkRedis(),
        ];

        $status = !in_array(false, $services, true);

        return $this->success(
            [
                'status' => $status ? 'healthy' : 'unhealthy',
                'services' => $services,
                'version' => '1.0.0',
            ],
            $status ? 'System is healthy' : 'System has issues',
            $status ? 200 : 503
        );
    }

    private function checkDatabase(): bool
    {
        try {
            DB::connection()->getPdo();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function checkRedis(): bool
    {
        try {
            Redis::connection()->ping();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
