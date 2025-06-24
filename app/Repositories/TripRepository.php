<?php
namespace App\Repositories;

use App\Models\V2\Trip;
use App\Models\V2\TripAuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

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
        $data = Trip::with(['creator', 'updater'])
            ->where('org_code', Auth::user()->org_code)
            ->select('trips.*');
            
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('start_time', function ($row) {
                return $row->start_time ? $row->start_time->format('Y-m-d H:i') : '';
            })
            ->editColumn('end_time', function ($row) {
                return $row->end_time ? $row->end_time->format('Y-m-d H:i') : '';
            })
            ->editColumn('status', function ($row) {
                switch($row->status) {
                    case 'completed':
                        $badgeClass = 'badge-success';
                        break;
                    case 'cancelled':
                        $badgeClass = 'badge-danger';
                        break;
                    default:
                        $badgeClass = 'badge-warning';
                        break;
                }
                return '<span class="badge ' . $badgeClass . '">' . ucfirst($row->status) . '</span>';
            })
            ->editColumn('is_locked', function ($row) {
                return $row->is_locked ? '<span class="badge badge-danger">Locked</span>' : '<span class="badge badge-success">Unlocked</span>';
            })
            ->rawColumns(['status', 'is_locked'])
            ->make(true);
    }
} 