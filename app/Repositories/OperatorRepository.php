<?php
namespace App\Repositories;

use App\Models\V1\User;
use App\Models\V2\Operator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class OperatorRepository implements OperatorRepositoryInterface
{
    public function all()
    {
        return Operator::latest()->get();
    }

    public function find($id)
    {
        return Operator::findOrFail($id);
    }

    public function create(array $data)
    {
        return Operator::create($data);
    }

    public function createWithUser(array $data)
    {
        try {
            return DB::transaction(function () use ($data) {
                $user = User::create([
                    'username'  => $data['username'],
                    'password'  =>  Hash::make($data['password']),
                    'org_code'  => Auth::user()->org_code,
                    'user_type' => 'operator',
                    'role_id' => 2,
                    'created_by' => Auth::user()->id
                ]);

                return Operator::create([
                    'name'             => $data['name'],
                    'designation'      => $data['designation'] ?? null,
                    'date_of_joining'  => $data['date_of_joining'] ?? null,
                    'mobile_number'    => $data['mobile_number'] ?? null,
                    'address'          => $data['address'] ?? null,
                    'user_id'          => $user->id,
                    'created_by'       => Auth::user()->id
                ]);
            });
        } catch (Exception $e) {
            throw new \Exception('Operator creation failed: ' . $e->getMessage());
        }
    }

    public function update($id, array $data)
    {
        $operator = Operator::findOrFail($id);
        $operator->update($data);
        return $operator;
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $operator = Operator::findOrFail($id);

            // Delete associated user if exists
            if ($operator->user_id) {
                $user = User::find($operator->user_id);
                if ($user) {
                    $user->delete(); // soft delete, or forceDelete() if needed
                }
            }

            // Delete the operator
            return $operator->delete(); // soft delete
        });
    }

    public function listDataForDataTable(){
        $data = Operator::with('user')->select('operators.*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

}
