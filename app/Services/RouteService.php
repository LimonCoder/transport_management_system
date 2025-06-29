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
     * Create a new route
     *
     * @param array $data
     * @return ServiceResponse
     */
    public function createRoute(array $data): ServiceResponse
    {
        try {
            $route = $this->routeRepository->create($data);
            return ServiceResponse::success('Route created successfully', 201, $route);
        } catch (\Exception $e) {
            Log::error('Error creating route: ' . $e->getMessage());
            return ServiceResponse::error('Failed to create route', $e->getMessage(), 500);
        }
    }

    public function listDataForDataTable(){
        return $this->routeRepository->listDataForDataTable();
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
     * Update an existing route
     *
     * @param int $id
     * @param array $data
     * @return ServiceResponse
     */
    public function updateRoute(int $id, array $data): ServiceResponse
    {
        try {
            $route = $this->routeRepository->find($id);
            
            if (!$route) {
                return ServiceResponse::error('Route not found', null, 404);
            }

            $updatedRoute = $this->routeRepository->update($id, $data);
            return ServiceResponse::success('Route updated successfully', 200, $updatedRoute);
        } catch (\Exception $e) {
            Log::error('Error updating route: ' . $e->getMessage());
            return ServiceResponse::error('Failed to update route', $e->getMessage(), 500);
        }
    }
} 