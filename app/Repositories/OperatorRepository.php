<?php
namespace App\Repositories;

use App\Models\V2\Operator;
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
                    'password'  => bcrypt($data['password']),
                    'user_type' => 'operator',
                ]);

                return Operator::create([
                    'name'             => $data['name'],
                    'username'         => $data['username'], // optional: if needed in operator table
                    'designation'      => $data['designation'] ?? null,
                    'date_of_joining'  => $data['date_of_joining'] ?? null,
                    'mobile'           => $data['mobile'] ?? null,
                    'password'         => bcrypt($data['password']),
                    'address'          => $data['address'] ?? null,
                    'user_id'          => $user->id,
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
        return Operator::destroy($id);
    }

    public function listDataForDataTable(){
        $data = Operator::with('user')->select('operators.*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

}
