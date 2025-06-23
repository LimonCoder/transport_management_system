<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Repositories\OperatorRepositoryInterface;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    protected $operatorRepo;

    public function __construct(OperatorRepositoryInterface $operatorRepo)
    {
        $this->operatorRepo = $operatorRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('V2.operator.index');
    }

    public function listData(){
        return $this->operatorRepo->listDataForDataTable();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'username'        => 'required|string|max:255|unique:users,username',
            'designation'     => 'required|string|max:255',
            'date_of_joining' => 'required|date',
            'mobile_number'   => 'required|string|regex:/^(?:\+88)?01[0-9]{9}$/',
            'password'        => 'required|string|min:6',
            'address'         => 'required|string',
        ]);

        try {
            $this->operatorRepo->createWithUser($validated);

            return response()->json([
                'status' => 'success',
                "title" => "Success",
                'message' => 'Operator created successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'title' => 'Error',
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'designation'     => 'nullable|string|max:255',
            'date_of_joining' => 'nullable|date',
            'mobile_number'   => 'required|string|regex:/^(?:\+88)?01[0-9]{9}$/',
            'address'         => 'nullable|string',
        ]);

        try {
            $this->operatorRepo->update($request->operator_id, $validated);

            return response()->json([
                'status' => 'success',
                'title' => 'Updated!',
                'message' => 'Operator updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'title' => 'Update Failed!',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $this->operatorRepo->delete($request->operator_id);

            return response()->json([
                'status' => 'success',
                'title' => 'Deleted!',
                'message' => 'Operator deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'title' => 'Delete Failed!',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
