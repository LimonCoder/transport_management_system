<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Services\OrganizationService;
use App\Http\Requests\V2\Organization\StoreOrganizationRequest;
use App\Http\Requests\V2\Organization\UpdateOrganizationRequest;
use App\Models\V1\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrganizationController extends Controller
{
    protected $organizationService;

    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;
    }

    /**
     * Display the organization management page
     *
     * @return View
     */
    public function index()
    {
        return view('v2.organization.index');
    }

    /**
     * Get organizations data for DataTable
     *
     * @return JsonResponse
     */
    public function listData(): JsonResponse
    {
        try {
            return $this->organizationService->listDataForDataTable();
        } catch (\Throwable $throwable) {
            Log::error("OrganizationController@listData", ['error' => $throwable]);
            return response()->json([
                'error' => 'An unexpected error occurred while retrieving organizations data'
            ], 500);
        }
    }

    /**
     * Get organizations for dropdown
     *
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        try {
            $result = $this->organizationService->getActiveOrganizationsForDropdown();
            
            if (!$result->isSuccess) {
                return ApiResponse::customResponse($result);
            }

            return ApiResponse::customResponse($result);
        } catch (\Throwable $throwable) {
            Log::error("OrganizationController@list", ['error' => $throwable]);
            return ApiResponse::errorResponse('An unexpected error occurred while retrieving organizations', 500);
        }
    }

    /**
     * Store a newly created organization in storage.
     *
     * @param StoreOrganizationRequest $request
     * @return JsonResponse
     */
    public function store(StoreOrganizationRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $result = $this->organizationService->createOrganization($validated);
            
            return ApiResponse::customResponse($result);
        } catch (\Throwable $throwable) {
            Log::error("OrganizationController@store", ['error' => $throwable]);
            return ApiResponse::errorResponse('An unexpected error occurred while creating organization', 500);
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
            $result = $this->organizationService->getOrganizationById($id);
            
            return ApiResponse::customResponse($result);
        } catch (\Throwable $throwable) {
            Log::error("OrganizationController@show", ['error' => $throwable]);
            return ApiResponse::errorResponse('An unexpected error occurred while retrieving organization', 500);
        }
    }

    /**
     * Update the specified organization in storage.
     *
     * @param UpdateOrganizationRequest $request
     * @return JsonResponse
     */
    public function update(UpdateOrganizationRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $organizationId = $validated['organization_id'];
            
            // Remove organization_id from validated data as it's not needed for the update
            unset($validated['organization_id']);
            
            $result = $this->organizationService->updateOrganization($organizationId, $validated);
            
            if (!$result->isSuccess) {
                return ApiResponse::customResponse($result);
            }

            return ApiResponse::customResponse($result);
        } catch (\Throwable $throwable) {
            Log::error("OrganizationController@update", ['error' => $throwable]);
            return ApiResponse::errorResponse('An unexpected error occurred while updating organization', 500);
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
            $organizationId = $request->organization_id;
            
            if (!$organizationId) {
                return response()->json([
                    'status' => 'error',
                    'title' => 'Error',
                    'message' => 'Organization ID is required'
                ], 400);
            }

            $result = $this->organizationService->deleteOrganization($organizationId);

            return ApiResponse::customResponse($result);
        } catch (\Exception $e) {
            Log::error("OrganizationController@destroy", ['error' => $e]);
            return response()->json([
                'status' => 'error',
                'title' => 'Delete Failed!',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Impersonate login as organization operator
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function impersonate(Request $request): JsonResponse
    {
        try {
            $userId = $request->user_id;
            
            if (!$userId) {
                return response()->json([
                    'status' => 'error',
                    'title' => 'Error',
                    'message' => 'User ID is required'
                ], 400);
            }

            $user = User::find($userId);
            
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'title' => 'Error',
                    'message' => 'User not found'
                ], 404);
            }

            if (!$user->is_special_user || $user->user_type !== 'operator') {
                return response()->json([
                    'status' => 'error',
                    'title' => 'Error',
                    'message' => 'User is not an organization operator'
                ], 403);
            }

            // Store original user ID for switching back
            session(['original_user_id' => Auth::id()]);
            
            // Login as the operator
            Auth::login($user);

            return response()->json([
                'status' => 'success',
                'title' => 'Success!',
                'message' => 'Successfully logged in as ' . $user->username,
                'redirect_url' => route('home')
            ]);
        } catch (\Exception $e) {
            Log::error("OrganizationController@impersonate", ['error' => $e]);
            return response()->json([
                'status' => 'error',
                'title' => 'Impersonate Failed!',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Switch back to original user
     *
     * @return JsonResponse
     */
    public function switchBack(): JsonResponse
    {
        try {
            $originalUserId = session('original_user_id');
            
            if (!$originalUserId) {
                return response()->json([
                    'status' => 'error',
                    'title' => 'Error',
                    'message' => 'No original user session found'
                ], 400);
            }

            $originalUser = User::find($originalUserId);
            
            if (!$originalUser) {
                return response()->json([
                    'status' => 'error',
                    'title' => 'Error',
                    'message' => 'Original user not found'
                ], 404);
            }

            // Clear the session
            session()->forget('original_user_id');
            
            // Login back as original user
            Auth::login($originalUser);

            return response()->json([
                'status' => 'success',
                'title' => 'Success!',
                'message' => 'Successfully switched back to your account',
                'redirect_url' => route('organizations.index')
            ]);
        } catch (\Exception $e) {
            Log::error("OrganizationController@switchBack", ['error' => $e]);
            return response()->json([
                'status' => 'error',
                'title' => 'Switch Back Failed!',
                'message' => $e->getMessage()
            ], 500);
        }
    }
} 