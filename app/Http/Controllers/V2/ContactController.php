<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Models\V2\Contact;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class ContactController extends Controller
{
    /**
     * Store a newly created contact in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return view('v2.contact.index');
    }
    public function list_data()
    {
        $orgCode = Auth::user()->org_code;
        $contacts = Contact::where('org_code', $orgCode)->get();
        return DataTables::of($contacts)
            ->addIndexColumn()
            ->make(true);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'org_code' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $contact = Contact::create($validator->validated());

        return response()->json([
            'status' => 'success',
            'data' => $contact,
        ], 201);
    }
} 