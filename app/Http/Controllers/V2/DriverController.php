<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Services\DriverService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\DriverRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Exception;

class DriverController extends Controller
{
    protected $driverRepo;
    protected $driverService;

    public function __construct(DriverRepositoryInterface $driverRepo, DriverService $driverService)
    {
        $this->driverRepo = $driverRepo;
        $this->driverService = $driverService;
    }

    /**
     * Display the driver management page.
     */
    public function index()
    {
        return view('v2.driver.index');
    }

    /**
     * Data for DataTables.
     */
    public function listData()
    {
        return $this->driverRepo->listDataForDataTable();
    }

    public function list(): JsonResponse
    {
        try {
            $result = $this->driverService->getActiveDriversForDropdown();

            return ApiResponse::customResponse($result);
        } catch (\Throwable $throwable) {
            Log::error("DriverController@list", ['error' => $throwable]);
            return ApiResponse::errorResponse('An unexpected error occurred while retrieving drivers', 500);
        }
    }

    /**
     * Store a new driver with associated user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:200',
            'username'        => 'required|string|unique:users,username',
            'password'        => 'required|string|min:6',
            'mobile_number'   => 'required|unique:drivers,mobile_number|string|regex:/^(?:\+88)?01[0-9]{9}$/',
            'license_number'  => 'nullable|unique:drivers,license_number',
        ]);

        try {
            $this->driverRepo->createWithUser($validated);

            return response()->json([
                'status' => 'success',
                'title' => 'Success',
                'message' => 'Driver created successfully!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'title' => 'Error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Update an existing driver.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'driver_id'       => 'required|exists:drivers,id',
            'name'            => 'required|string|max:200',
            'mobile_number'   => 'required|unique:drivers,mobile_number,' . $request->driver_id,
            'license_number'  => 'nullable|unique:drivers,license_number,' . $request->driver_id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'title' => 'Validation Error',
                'message' => 'Please fix the errors below.',
                'errors' => $validator->errors(),
            ]);
        }

        try {
            $this->driverRepo->update($request->driver_id, $request->all());

            return response()->json([
                'status' => 'success',
                'title' => 'Updated',
                'message' => 'Driver updated successfully!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'title' => 'Error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Delete a driver.
     */
    public function destroy(Request $request): JsonResponse
    {
        try {
            $this->driverRepo->delete($request->driver_id);
            return response()->json([
                'status' => 'success',
                'title' => 'Deleted',
                'message' => 'Driver deleted successfully!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'title' => 'Error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}

