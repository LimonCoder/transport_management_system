<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Models\V2\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class NoticeController extends Controller
{
    public function index()
    {
        return view('v2.notice.index');
    }

    public function list_data()
    {
        $orgCode = Auth::user()->org_code;
        $notices = Notice::where('org_code', $orgCode)->get();
        return DataTables::of($notices)
            ->addIndexColumn()
            ->make(true);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'required|string',
        ]);
        $data['org_code'] = Auth::user()->org_code;
        $data['created_by'] = Auth::user()->id;
        Notice::create($data);
        return response()->json(['success' => true, 'message' => 'Notice Added Successfully!']);
    }

    public function update(Request $request)
    {
        $notice = Notice::findOrFail($request->notice_id);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'required|string',
        ]);
        $data['updated_by'] = Auth::user()->id;
        $notice->update($data);
        return response()->json(['success' => true, 'message' => 'Notice Updated Successfully!']);
    }

    public function destroy(Request $request)
    {
        $notice = Notice::findOrFail($request->notice_id);
        $notice->delete();
        return response()->json(['success' => true, 'message' => 'Notice Deleted Successfully!']);
    }
}