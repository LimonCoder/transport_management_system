<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\DriverRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Exception;

class DriverController extends Controller
{
    protected $driverRepo;

    public function __construct(DriverRepositoryInterface $driverRepo)
    {
        $this->driverRepo = $driverRepo;
    }

    /**
     * Display the driver management page.
     */
    public function index()
    {
        return view('V2.driver.index');
    }

    /**
     * Data for DataTables.
     */
    public function listData()
    {
        return $this->driverRepo->listDataForDataTable();
    }

    /**
     * Store a new driver with associated user.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'            => 'required|string|max:200',
            'username'        => 'required|string|unique:users,username',
            'password'        => 'required|string|min:6',
            'mobile_number'   => 'required|unique:drivers,mobile_number',
            'license_number'  => 'nullable|unique:drivers,license_number',
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
            $this->driverRepo->createWithUser($request->all());

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
    public function destroy(Request $request)
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
