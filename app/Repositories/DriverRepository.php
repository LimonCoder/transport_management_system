<?php

namespace App\Repositories;

use App\Models\V1\User;
use App\Models\V2\Driver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Illuminate\Support\Facades\Auth;

class DriverRepository implements DriverRepositoryInterface
{
    public function all()
    {
        return Driver::where('org_code', Auth::user()->org_code)
            ->latest()
            ->get();
    }

    public function find($id)
    {
        return Driver::where('org_code', Auth::user()->org_code)
            ->findOrFail($id);
    }

    /**
     * @throws Exception
     */
    public function createWithUser(array $data)
    {
        try {
            return DB::transaction(function () use ($data) {
                $user = User::create([
                    'username' => $data['username'],
                    'password' => Hash::make($data['password']),
                    'org_code' => Auth::user()->org_code,
                    'user_type' => 'driver',
                    'role_id' => 3, // assume role_id for driver
                    'created_by' => Auth::id()
                ]);

                return Driver::create([
                    'user_id' => $user->id,
                    'org_code' => Auth::user()->org_code,
                    'name' => $data['name'],
                    'license_number' => $data['license_number'] ?? null,
                    'date_of_joining' => $data['date_of_joining'] ?? null,
                    'mobile_number' => $data['mobile_number'],
                    'address' => $data['address'] ?? null,
                    'created_by' => Auth::id()
                ]);
            });
        } catch (Exception $e) {
            throw new Exception('Driver creation failed: ' . $e->getMessage());
        }
    }


    public function update($id, array $data)
    {
        $driver = $this->find($id);
        $driver->update($data);
        return $driver;
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $driver = Driver::findOrFail($id);

            if ($driver->user_id) {
                $user = User::find($driver->user_id);
                if ($user) {
                    $user->delete(); // soft delete
                }
            }

            return $driver->delete();
        });
    }

    public function listDataForDataTable()
    {
        $data = Driver::with('user')->select('drivers.*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function getActiveDrivers()
    {
        return Driver::where('org_code', Auth::user()->org_code)
            ->select('id', 'name')
            ->get();
    }
}
