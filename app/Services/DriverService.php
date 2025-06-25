<?php

namespace App\Services;

use App\Libraries\ServiceResponse;
use App\Repositories\DriverRepositoryInterface;
use Illuminate\Support\Facades\Log;

class DriverService
{
    protected $driverRepository;

    public function __construct(DriverRepositoryInterface $driverRepository)
    {
        $this->driverRepository = $driverRepository;
    }

    /**
     * Get all drivers
     *
     * @return ServiceResponse
     */
    public function getAllDrivers(): ServiceResponse
    {
        try {
            $drivers = $this->driverRepository->all();
            return ServiceResponse::success('Drivers retrieved successfully', 200, $drivers);
        } catch (\Exception $e) {
            Log::error('Error retrieving drivers: ' . $e->getMessage());
            return ServiceResponse::error('Failed to retrieve drivers', $e->getMessage(), 500);
        }
    }

    /**
     * Get driver by ID
     *
     * @param int $id
     * @return ServiceResponse
     */
    public function getDriverById(int $id): ServiceResponse
    {
        try {
            $driver = $this->driverRepository->find($id);
            
            if (!$driver) {
                return ServiceResponse::error('Driver not found', null, 404);
            }

            return ServiceResponse::success('Driver retrieved successfully', 200, $driver);
        } catch (\Exception $e) {
            Log::error('Error retrieving driver: ' . $e->getMessage());
            return ServiceResponse::error('Failed to retrieve driver', $e->getMessage(), 500);
        }
    }

    /**
     * Get active drivers for dropdown
     *
     * @return ServiceResponse
     */
    public function getActiveDriversForDropdown(): ServiceResponse
    {
        try {
            $drivers = $this->driverRepository->getActiveDrivers();
            return ServiceResponse::success('Active drivers retrieved successfully', 200, $drivers);
        } catch (\Exception $e) {
            Log::error('Error retrieving active drivers: ' . $e->getMessage());
            return ServiceResponse::error('Failed to retrieve active drivers', $e->getMessage(), 500);
        }
    }
} 