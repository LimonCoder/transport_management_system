<?php

namespace App\Services;

use App\Libraries\ServiceResponse;
use App\Repositories\RouteRepositoryInterface;
use Illuminate\Support\Facades\Log;

class RouteService
{
    protected $routeRepository;

    public function __construct(RouteRepositoryInterface $routeRepository)
    {
        $this->routeRepository = $routeRepository;
    }

    /**
     * Get all routes
     *
     * @return ServiceResponse
     */
    public function getAllRoutes(): ServiceResponse
    {
        try {
            $routes = $this->routeRepository->all();
            return ServiceResponse::success('Routes retrieved successfully', 200, $routes);
        } catch (\Exception $e) {
            Log::error('Error retrieving routes: ' . $e->getMessage());
            return ServiceResponse::error('Failed to retrieve routes', $e->getMessage(), 500);
        }
    }

    /**
     * Get route by ID
     *
     * @param int $id
     * @return ServiceResponse
     */
    public function getRouteById(int $id): ServiceResponse
    {
        try {
            $route = $this->routeRepository->find($id);
            
            if (!$route) {
                return ServiceResponse::error('Route not found', null, 404);
            }

            return ServiceResponse::success('Route retrieved successfully', 200, $route);
        } catch (\Exception $e) {
            Log::error('Error retrieving route: ' . $e->getMessage());
            return ServiceResponse::error('Failed to retrieve route', $e->getMessage(), 500);
        }
    }

    /**
     * Get active routes for dropdown
     *
     * @return ServiceResponse
     */
    public function getActiveRoutesForDropdown(): ServiceResponse
    {
        try {
            $routes = $this->routeRepository->getActiveRoutes();
            return ServiceResponse::success('Active routes retrieved successfully', 200, $routes);
        } catch (\Exception $e) {
            Log::error('Error retrieving active routes: ' . $e->getMessage());
            return ServiceResponse::error('Failed to retrieve active routes', $e->getMessage(), 500);
        }
    }
} 