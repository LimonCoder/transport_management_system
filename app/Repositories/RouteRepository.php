<?php
namespace App\Repositories;

use App\Models\V2\Route;
use Illuminate\Support\Facades\Auth;

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
} 