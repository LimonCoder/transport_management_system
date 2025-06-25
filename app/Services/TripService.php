<?php

namespace App\Services;

use App\Libraries\ServiceResponse;
use App\Repositories\TripRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TripService
{
    protected $tripRepository;

    public function __construct(TripRepositoryInterface $tripRepository)
    {
        $this->tripRepository = $tripRepository;
    }

    /**
     * Get all trips
     *
     * @return ServiceResponse
     */
    public function getAllTrips(): ServiceResponse
    {
        try {
            $trips = $this->tripRepository->all();
            return ServiceResponse::success('Trips retrieved successfully', 200, $trips);
        } catch (\Exception $e) {
            Log::error('Error retrieving trips: ' . $e->getMessage());
            return ServiceResponse::error('Failed to retrieve trips', $e->getMessage(), 500);
        }
    }

    /**
     * Get trip by ID
     *
     * @param int $id
     * @return ServiceResponse
     */
    public function getTripById(int $id): ServiceResponse
    {
        try {
            $trip = $this->tripRepository->find($id);
            
            if (!$trip) {
                return ServiceResponse::error('Trip not found', null, 404);
            }

            return ServiceResponse::success('Trip retrieved successfully', 200, $trip);
        } catch (\Exception $e) {
            Log::error('Error retrieving trip: ' . $e->getMessage());
            return ServiceResponse::error('Failed to retrieve trip', $e->getMessage(), 500);
        }
    }

    /**
     * Create a new trip
     *
     * @param array $data
     * @return ServiceResponse
     */
    public function createTrip(array $data): ServiceResponse
    {
        try {
            $data = $this->enrichTripData($data);
            $trip = $this->tripRepository->createTripWithAuditLog($data);
            
            return ServiceResponse::success('Trip created successfully', 201, $trip);
        } catch (\Exception $e) {
            Log::error('Error creating trip: ' . $e->getMessage());
            return ServiceResponse::error('Failed to create trip', $e->getMessage(), 500);
        }
    }

    /**
     * Update an existing trip
     *
     * @param int $id
     * @param array $data
     * @return ServiceResponse
     */
    public function updateTrip(int $id, array $data): ServiceResponse
    {
        try {
            // Check if trip exists
            $existingTrip = $this->tripRepository->find($id);
            if (!$existingTrip) {
                return ServiceResponse::error('Trip not found', null, 404);
            }

            // Check if trip is locked
            if ($existingTrip->is_locked) {
                return ServiceResponse::error('Cannot update locked trip', null, 403);
            }

            // Additional business logic for updates
            $data = $this->enrichTripData($data, $existingTrip);

            $trip = $this->tripRepository->updateTripWithAuditLog($id, $data);
            
            return ServiceResponse::success('Trip updated successfully', 200, $trip);
        } catch (\Exception $e) {
            Log::error('Error updating trip: ' . $e->getMessage());
            return ServiceResponse::error('Failed to update trip', $e->getMessage(), 500);
        }
    }

    /**
     * Delete a trip
     *
     * @param int $id
     * @return ServiceResponse
     */
    public function deleteTrip(int $id): ServiceResponse
    {
        try {
            $trip = $this->tripRepository->find($id);
            
            if (!$trip) {
                return ServiceResponse::error('Trip not found', null, 404);
            }

            // Check if trip is locked
            if ($trip->is_locked) {
                return ServiceResponse::error('Cannot delete locked trip', null, 403);
            }

            $this->tripRepository->delete($id);
            
            return ServiceResponse::success('Trip deleted successfully', 200, null);
        } catch (\Exception $e) {
            Log::error('Error deleting trip: ' . $e->getMessage());
            return ServiceResponse::error('Failed to delete trip', $e->getMessage(), 500);
        }
    }

    /**
     * Get trips data for DataTable
     *
     * @return ServiceResponse
     */
    public function getTripsForDataTable(): ServiceResponse
    {
        try {
            $data = $this->tripRepository->listDataForDataTable();
            return ServiceResponse::success('Trips data retrieved successfully', 200, $data);
        } catch (\Exception $e) {
            Log::error('Error retrieving trips for datatable: ' . $e->getMessage());
            return ServiceResponse::error('Failed to retrieve trips data', $e->getMessage(), 500);
        }
    }



    /**
     * Enrich trip data with additional information
     *
     * @param array $data
     * @param object|null $existingTrip
     * @return array
     */
    private function enrichTripData(array $data, $existingTrip = null): array
    {
        // Set organization code if creating new trip
        if (!$existingTrip) {
            $data['org_code'] = Auth::user()->org_code;
            $data['created_by'] = Auth::user()->id;
        } else {
            $data['updated_by'] = Auth::user()->id;
        }

        return $data;
    }


} 