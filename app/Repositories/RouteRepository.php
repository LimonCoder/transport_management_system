<?php
namespace App\Repositories;

use App\Models\V2\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class RouteRepository implements RouteRepositoryInterface
{
    public function all()
    {
        return Route::where('org_code', Auth::user()->org_code)
            ->latest()
            ->get();
    }

    public function find($id)
    {
        return Route::where('org_code', Auth::user()->org_code)
            ->findOrFail($id);
    }

    public function create(array $data)
    {
        $data['org_code'] = Auth::user()->org_code;
        $data['created_by'] = Auth::user()->id;
        return Route::create($data);
    }

    public function update($id, array $data)
    {
        $route = $this->find($id);
        $data['updated_by'] = Auth::user()->id;
        $route->update($data);
        return $route;
    }

    public function delete($id)
    {
        $route = $this->find($id);
        return $route->delete(); // soft delete
    }

    public function getActiveRoutes()
    {
        return Route::where('org_code', Auth::user()->org_code)
            ->where('status', 'active')
            ->select('id', 'title as name')
            ->get();
    }

    public function listDataForDataTable()
    {
        try {
            Log::info('RouteRepository@listDataForDataTable called');
            
            $data = Route::where('org_code', Auth::user()->org_code)
                ->select('id', 'org_code', 'title', 'details', 'status', 'created_at', 'updated_at');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : '';
                })
                ->editColumn('details', function ($row) {
                    return $row->details ? (strlen($row->details) > 50 ? substr($row->details, 0, 50) . '...' : $row->details) : '';
                })
                ->editColumn('status', function ($row) {
                    return $row->status === 'active' 
                        ? '<span class="badge badge-success">Active</span>' 
                        : '<span class="badge badge-danger">Inactive</span>';
                })
                ->rawColumns(['status'])
                ->make(true);
        } catch (\Exception $e) {
            Log::error('RouteRepository@listDataForDataTable error: ' . $e->getMessage());
            throw $e;
        }
    }
} 