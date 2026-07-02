<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class HealthController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return ApiResponse::success(
            message: 'Universe API is running.',
            data: [
                'version' => config('app.version', '1.0.0'),
                'timestamp' => now()->toISOString(),
            ]
        );
    }
}