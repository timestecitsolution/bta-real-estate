<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingQuery;
use App\Models\WebmasterSection;

class ClientVisitRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        $requests = BookingQuery::with('project')->get();
        // dd($requests->project);
        return view('dashboard.client-visit-requests.list', compact('requests', 'GeneralWebmasterSections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $request = BookingQuery::findOrFail($id);

        if (request()->ajax()) {
            return response()->json($request);
        }

        return view('dashboard.client-visit-requests.preview', compact('request'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $request = BookingQuery::find($id);
        if ($request) {
            $request->delete();
        }
        return redirect()->back()->with('success', 'Client Visit Request deleted successfully.');
    }
}
