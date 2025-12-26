<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Services\RouteService;
use App\Http\Requests\V2\Route\StoreRouteRequest;
use App\Http\Requests\V2\Route\UpdateRouteRequest;
use App\Repositories\RouteRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class RouteController extends Controller
{
    protected $routeService;

    public function __construct(RouteService $routeService)
    {
        $this->routeService = $routeService;
    }

    /**
     * Display the route management page
     *
     * @return View
     */
    public function index()
    {
        return view('v2.route.index');
    }

    /**
     * Get routes data for DataTable
     *
     * @return JsonResponse
     */
    public function listData(): JsonResponse
    {
        try {
            return $this->routeService->listDataForDataTable();
        } catch (\Throwable $throwable) {
            Log::error("RouteController@listData", ['error' => $throwable]);
            return response()->json([
                'error' => __('message.route_error_retrieving_data')
            ], 500);
        }
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
            return ApiResponse::errorResponse(__('message.route_error_retrieving'), 500);
        }
    }

    /**
     * Store a newly created route in storage.
     *
     * @param StoreRouteRequest $request
     * @return JsonResponse
     */
    public function store(StoreRouteRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            
            $result = $this->routeService->createRoute($validated);
            
            return ApiResponse::customResponse($result);
        } catch (\Throwable $throwable) {
            Log::error("RouteController@store", ['error' => $throwable]);
            return ApiResponse::errorResponse(__('message.route_error_creating'), 500);
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
            return ApiResponse::errorResponse(__('message.route_error_retrieving_single'), 500);
        }
    }

    /**
     * Update the specified route in storage.
     *
     * @param UpdateRouteRequest $request
     * @return JsonResponse
     */
    public function update(UpdateRouteRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $routeId = $validated['route_id'];
            
            // Remove route_id from validated data as it's not needed for the update
            unset($validated['route_id']);
            
            $result = $this->routeService->updateRoute($routeId, $validated);
            
            if (!$result->isSuccess) {
                return ApiResponse::customResponse($result);
            }

            return ApiResponse::customResponse($result);
        } catch (\Throwable $throwable) {
            Log::error("RouteController@update", ['error' => $throwable]);
            return ApiResponse::errorResponse(__('message.route_error_updating'), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        try {
            $routeId = $request->route_id;
            
            if (!$routeId) {
                return response()->json([
                    'status' => 'error',
                    'title' => __('message.error'),
                    'message' => __('message.route_id_required')
                ], 400);
            }

            $this->routeRepo->delete($routeId);

            return response()->json([
                'status' => 'success',
                'title' => __('message.deleted'),
                'message' => __('message.route_deleted_successfully')
            ]);
        } catch (\Exception $e) {
            Log::error("RouteController@destroy", ['error' => $e]);
            return response()->json([
                'status' => 'error',
                'title' => __('message.route_delete_failed'),
                'message' => $e->getMessage()
            ], 500);
        }
    }
} 