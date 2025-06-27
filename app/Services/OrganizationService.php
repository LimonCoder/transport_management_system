<?php

namespace App\Services;

use App\Libraries\ServiceResponse;
use App\Repositories\OrganizationRepositoryInterface;
use Illuminate\Support\Facades\Log;

class OrganizationService
{
    protected $organizationRepository;

    public function __construct(OrganizationRepositoryInterface $organizationRepository)
    {
        $this->organizationRepository = $organizationRepository;
    }

    /**
     * Create a new organization
     *
     * @param array $data
     * @return ServiceResponse
     */
    public function createOrganization(array $data): ServiceResponse
    {
        try {
            $organization = $this->organizationRepository->create($data);
            return ServiceResponse::success('Organization created successfully with operator account', 201, $organization);
        } catch (\Exception $e) {
            Log::error('Error creating organization: ' . $e->getMessage());
            return ServiceResponse::error('Failed to create organization', $e->getMessage(), 500);
        }
    }

    public function listDataForDataTable(){
        return $this->organizationRepository->listDataForDataTable();
    }

    /**
     * Get active organizations for dropdown
     *
     * @return ServiceResponse
     */
    public function getActiveOrganizationsForDropdown(): ServiceResponse
    {
        try {
            $organizations = $this->organizationRepository->getActiveOrganizations();
            return ServiceResponse::success('Active organizations retrieved successfully', 200, $organizations);
        } catch (\Exception $e) {
            Log::error('Error retrieving active organizations: ' . $e->getMessage());
            return ServiceResponse::error('Failed to retrieve active organizations', $e->getMessage(), 500);
        }
    }

    /**
     * Get all organizations
     *
     * @return ServiceResponse
     */
    public function getAllOrganizations(): ServiceResponse
    {
        try {
            $organizations = $this->organizationRepository->all();
            return ServiceResponse::success('Organizations retrieved successfully', 200, $organizations);
        } catch (\Exception $e) {
            Log::error('Error retrieving organizations: ' . $e->getMessage());
            return ServiceResponse::error('Failed to retrieve organizations', $e->getMessage(), 500);
        }
    }

    /**
     * Get organization by ID
     *
     * @param int $id
     * @return ServiceResponse
     */
    public function getOrganizationById(int $id): ServiceResponse
    {
        try {
            $organization = $this->organizationRepository->find($id);

            if (!$organization) {
                return ServiceResponse::error('Organization not found', null, 404);
            }

            return ServiceResponse::success('Organization retrieved successfully', 200, $organization);
        } catch (\Exception $e) {
            Log::error('Error retrieving organization: ' . $e->getMessage());
            return ServiceResponse::error('Failed to retrieve organization', $e->getMessage(), 500);
        }
    }

    /**
     * Update an existing organization
     *
     * @param int $id
     * @param array $data
     * @return ServiceResponse
     */
    public function updateOrganization(int $id, array $data): ServiceResponse
    {
        try {
            $organization = $this->organizationRepository->find($id);
            
            if (!$organization) {
                return ServiceResponse::error('Organization not found', null, 404);
            }

            $updatedOrganization = $this->organizationRepository->update($id, $data);
            return ServiceResponse::success('Organization updated successfully', 200, $updatedOrganization);
        } catch (\Exception $e) {
            Log::error('Error updating organization: ' . $e->getMessage());
            return ServiceResponse::error('Failed to update organization', $e->getMessage(), 500);
        }
    }

    /**
     * Delete an organization
     *
     * @param int $id
     * @return ServiceResponse
     */
    public function deleteOrganization(int $id): ServiceResponse
    {
        try {
            $organization = $this->organizationRepository->find($id);
            
            if (!$organization) {
                return ServiceResponse::error('Organization not found', null, 404);
            }

            $this->organizationRepository->delete($id);
            return ServiceResponse::success('Organization deleted successfully', 200);
        } catch (\Exception $e) {
            Log::error('Error deleting organization: ' . $e->getMessage());
            return ServiceResponse::error('Failed to delete organization', $e->getMessage(), 500);
        }
    }
} 