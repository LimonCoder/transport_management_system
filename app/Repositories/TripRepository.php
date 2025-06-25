<?php
namespace App\Repositories;

use App\Models\V2\Trip;
use App\Models\V2\TripAuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class TripRepository implements TripRepositoryInterface
{
    public function all()
    {
        return Trip::latest()->get();
    }

    public function find($id)
    {
        return Trip::findOrFail($id);
    }

    public function create(array $data)
    {
        return Trip::create($data);
    }

    public function createTripWithAuditLog(array $data)
    {
        try {
            return DB::transaction(function () use ($data) {
                // Add default values
                $data['org_code'] = Auth::user()->org_code;
                $data['created_by'] = Auth::user()->id;

                // Fetch driver name from drivers table
                $driver = DB::table('drivers')
                    ->where('id', $data['driver_id'])
                    ->where('org_code', Auth::user()->org_code)
                    ->first();
                
                if (!$driver) {
                    throw new \Exception('Driver not found');
                }
                $data['driver_name'] = $driver->name;

                // Fetch vehicle registration number from vehicles table
                $vehicle = DB::table('vehicles')
                    ->where('id', $data['vehicle_id'])
                    ->where('org_code', Auth::user()->org_code)
                    ->first();
                
                if (!$vehicle) {
                    throw new \Exception('Vehicle not found');
                }
                $data['vehicle_registration_number'] = $vehicle->registration_number;

                // Create the trip
                $trip = Trip::create($data);

                // Create audit log entry
                $auditData = array_merge($data, [
                    'primary_id' => $trip->id,
                    'action' => 'create',
                    'status' => 'initiate'
                ]);

                TripAuditLog::create($auditData);

                return $trip;
            });
        } catch (\Exception $e) {
            throw new \Exception('Trip creation failed: ' . $e->getMessage());
        }
    }

    public function update($id, array $data)
    {
        $trip = Trip::findOrFail($id);
        $trip->update($data);
        return $trip;
    }

    public function updateTripWithAuditLog($id, array $data)
    {
        try {
            return DB::transaction(function () use ($id, $data) {
                $trip = Trip::findOrFail($id);
                
                // Add updated_by
                $data['updated_by'] = Auth::user()->id;
                
                // Fetch driver name from drivers table if driver_id is being updated
                if (isset($data['driver_id'])) {
                    $driver = DB::table('drivers')
                        ->where('id', $data['driver_id'])
                        ->where('org_code', $trip->org_code)
                        ->first();
                    
                    if (!$driver) {
                        throw new \Exception('Driver not found');
                    }
                    $data['driver_name'] = $driver->name;
                }

                // Fetch vehicle registration number from vehicles table if vehicle_id is being updated
                if (isset($data['vehicle_id'])) {
                    $vehicle = DB::table('vehicles')
                        ->where('id', $data['vehicle_id'])
                        ->where('org_code', $trip->org_code)
                        ->first();
                    
                    if (!$vehicle) {
                        throw new \Exception('Vehicle not found');
                    }
                    $data['vehicle_registration_number'] = $vehicle->registration_number;
                }
                
                // Update the trip
                $trip->update($data);

                // Create audit log entry for modification
                $auditData = array_merge($data, [
                    'primary_id' => $trip->id,
                    'org_code' => $trip->org_code,
                    'action' => 'modify',
                    'created_by' => Auth::user()->id
                ]);

                TripAuditLog::create($auditData);

                return $trip;
            });
        } catch (\Exception $e) {
            throw new \Exception('Trip update failed: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $trip = Trip::findOrFail($id);
            return $trip->delete(); // soft delete
        });
    }

    public function listDataForDataTable()
    {
        try {
            Log::info('TripRepository@listDataForDataTable called');
            
            $data = Trip::leftJoin('routes', 'trips.route_id', '=', 'routes.id')
                ->leftJoin('drivers', 'trips.driver_id', '=', 'drivers.id')
                ->leftJoin('vehicles', 'trips.vehicle_id', '=', 'vehicles.id')
                ->where('trips.org_code', Auth::user()->org_code)
                ->select(
                    'trips.*',
                    'routes.title as route_name',
                    'drivers.name as driver_name',
                    'vehicles.registration_number as vehicle_registration_number'
                );

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('trip_initiate_date', function ($row) {
                    return $row->trip_initiate_date ? $row->trip_initiate_date->format('Y-m-d') : '';
                })
                ->editColumn('is_locked', function ($row) {
                    return $row->is_locked ? '<span class="badge badge-danger">Locked</span>' : '<span class="badge badge-success">Unlocked</span>';
                })
                ->editColumn('route_name', function ($row) {
                    return $row->route_name ?: 'Route #' . $row->route_id;
                })
                ->editColumn('driver_name', function ($row) {
                    return $row->driver_name ?: 'N/A';
                })
                ->editColumn('vehicle_registration_number', function ($row) {
                    return $row->vehicle_registration_number ?: 'N/A';
                })
                ->rawColumns(['is_locked'])
                ->make(true);
        } catch (\Exception $e) {
            Log::error('TripRepository@listDataForDataTable error: ' . $e->getMessage());
            throw $e;
        }
    }


} 