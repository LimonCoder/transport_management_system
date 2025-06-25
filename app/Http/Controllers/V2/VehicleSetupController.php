<?php

namespace App\Http\Controllers\V2;

use App\helpers\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Models\V2\VehicleSetup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;


class VehicleSetupController extends Controller
{

    // Show the vehicle management page
    public function index()
    {
        return view('v2.vehicle.index');
    }

    // Data for DataTables
    public function list_data()
    {
        $vehicles = VehicleSetup::whereNull('deleted_at')->get();
        return DataTables::of($vehicles)
            ->addIndexColumn()
            ->make(true);
    }

    // Store a new vehicle (single image)
    public function store(Request $request)
    {
        $data = $request->validate([
            'registration_number' => 'required|string|unique:vehicles',
            'model' => 'nullable|string',
            'capacity' => 'nullable|string',
            'fuel_type_id' => 'required|numeric',
            'status' => 'required|string',
            'images' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('images')) {
            $file = $request->file('images');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/vehicles', $filename);
            $data['images'] = 'storage/vehicles/' . $filename;
        } else {
            $data['images'] = null;
        }

        // Set creator and org code
        $user = auth()->user();
        $data['created_by'] = $user->id ?? 1;
        $data['org_code'] = $user->org_code ?? '1001';

        VehicleSetup::create($data);

        // Insert into vehicles_audit_log
        $auditData = [
            'primary_id' => VehicleSetup::latest('id')->first()->id,
            'org_code' => $data['org_code'],
            'registration_number' => $data['registration_number'],
            'model' => $data['model'] ?? '',
            'capacity' => $data['capacity'] ?? null,
            'fuel_type_id' => $data['fuel_type_id'],
            'images' => $data['images'],
            'status' => $data['status'],
            'action' => 'create',
            'created_by' => $data['created_by'],
            'created_at' => now(),
        ];
        \App\Models\V2\VehiclesAuditLog::create($auditData);

        return response()->json([
            'success' => true,
            'message' => 'Vehicle Added Successfully!'
        ]);
    }

    // Update an existing vehicle (single image)
    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:vehicles,id',
            'model' => 'nullable|string',
            'capacity' => 'nullable|string',
            'fuel_type_id' => 'required|numeric',
            'status' => 'required|string',
            'images' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $vehicle = VehicleSetup::findOrFail($request->id);

        // Handle image upload
        if ($request->hasFile('images')) {
            $file = $request->file('images');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/vehicles', $filename);
            $data['images'] = 'storage/vehicles/' . $filename;
        } else {
            $data['images'] = $vehicle->images;
        }

        // Set updater and org code
        $user = auth()->user();
        $data['updated_by'] = $user->id ?? 1;
        $data['org_code'] = $user->org_code ?? $vehicle->org_code;

        $vehicle->update($data);

        // Insert into vehicles_audit_log for update
        $auditData = [
            'primary_id' => $vehicle->id,
            'org_code' => $data['org_code'],
            'registration_number' => $vehicle->registration_number,
            'model' => $data['model'] ?? '',
            'capacity' => $data['capacity'] ?? null,
            'fuel_type_id' => $data['fuel_type_id'],
            'images' => $data['images'],
            'status' => $data['status'],
            'action' => 'modify',
            'created_by' => $data['updated_by'],
            'created_at' => now(),
        ];
        \App\Models\V2\VehiclesAuditLog::create($auditData);

        return response()->json([
            'success' => true,
            'message' => 'Vehicle updated successfully!'
        ]);
    }

    // Delete a vehicle
    public function destroy(Request $request)
    {
        $isDelete = VehicleSetup::find($request->row_id)->delete();
        return response()->json([
            'status' => $isDelete ? 'success' : 'error',
            'title' => $isDelete ? 'Success' : 'error',
            'message' => $isDelete ? 'Vehicle Deleted successfully!' : 'Vehicle Deleted Field'
        ]);
    }


}

?>
