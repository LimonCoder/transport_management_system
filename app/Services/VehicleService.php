<?php

namespace App\Services;

use App\Libraries\ServiceResponse;
use App\Repositories\VehicleRepositoryInterface;
use Illuminate\Support\Facades\Log;

class VehicleService
{
    protected $vehicleRepository;

    public function __construct(VehicleRepositoryInterface $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * Get all vehicles
     *
     * @return ServiceResponse
     */
    public function getAllVehicles(): ServiceResponse
    {
        try {
            $vehicles = $this->vehicleRepository->all();
            return ServiceResponse::success('Vehicles retrieved successfully', 200, $vehicles);
        } catch (\Exception $e) {
            Log::error('Error retrieving vehicles: ' . $e->getMessage());
            return ServiceResponse::error('Failed to retrieve vehicles', $e->getMessage(), 500);
        }
    }

    /**
     * Get vehicle by ID
     *
     * @param int $id
     * @return ServiceResponse
     */
    public function getVehicleById(int $id): ServiceResponse
    {
        try {
            $vehicle = $this->vehicleRepository->find($id);
            
            if (!$vehicle) {
                return ServiceResponse::error('Vehicle not found', null, 404);
            }

            return ServiceResponse::success('Vehicle retrieved successfully', 200, $vehicle);
        } catch (\Exception $e) {
            Log::error('Error retrieving vehicle: ' . $e->getMessage());
            return ServiceResponse::error('Failed to retrieve vehicle', $e->getMessage(), 500);
        }
    }

    /**
     * Get active vehicles for dropdown
     *
     * @return ServiceResponse
     */
    public function getActiveVehiclesForDropdown(): ServiceResponse
    {
        try {
            $vehicles = $this->vehicleRepository->getActiveVehicles();
            return ServiceResponse::success('Active vehicles retrieved successfully', 200, $vehicles);
        } catch (\Exception $e) {
            Log::error('Error retrieving active vehicles: ' . $e->getMessage());
            return ServiceResponse::error('Failed to retrieve active vehicles', $e->getMessage(), 500);
        }
    }
} 