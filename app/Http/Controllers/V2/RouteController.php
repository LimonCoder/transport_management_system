<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Services\RouteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class RouteController extends Controller
{
    protected $routeService;

    public function __construct(RouteService $routeService)
    {
        $this->routeService = $routeService;
    }

    /**
     * Get routes for dropdown
     *
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        try {
            $result = $this->routeService->getActiveRoutesForDropdown();
            
            if (!$result->isSuccess) {
                return ApiResponse::customResponse($result);
            }

            return ApiResponse::customResponse($result);
        } catch (\Throwable $throwable) {
            Log::error("RouteController@list", ['error' => $throwable]);
            return ApiResponse::errorResponse('An unexpected error occurred while retrieving routes', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $result = $this->routeService->getRouteById($id);
            
            return ApiResponse::customResponse($result);
        } catch (\Throwable $throwable) {
            Log::error("RouteController@show", ['error' => $throwable]);
            return ApiResponse::errorResponse('An unexpected error occurred while retrieving route', 500);
        }
    }
} 