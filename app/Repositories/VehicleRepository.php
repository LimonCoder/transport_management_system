<?php
namespace App\Repositories;

use App\Models\V2\Vehicle;
use Illuminate\Support\Facades\Auth;

class VehicleRepository implements VehicleRepositoryInterface
{
    public function all()
    {
        return Vehicle::where('org_code', Auth::user()->org_code)
            ->latest()
            ->get();
    }

    public function find($id)
    {
        return Vehicle::where('org_code', Auth::user()->org_code)
            ->findOrFail($id);
    }

    public function create(array $data)
    {
        $data['org_code'] = Auth::user()->org_code;
        $data['created_by'] = Auth::user()->id;
        return Vehicle::create($data);
    }

    public function update($id, array $data)
    {
        $vehicle = $this->find($id);
        $data['updated_by'] = Auth::user()->id;
        $vehicle->update($data);
        return $vehicle;
    }

    public function delete($id)
    {
        $vehicle = $this->find($id);
        return $vehicle->delete(); // soft delete
    }

    public function getActiveVehicles()
    {
        return Vehicle::where('org_code', Auth::user()->org_code)
            ->where('status', 'active')
            ->select('id', 'registration_number')
            ->get();
    }
} 