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
