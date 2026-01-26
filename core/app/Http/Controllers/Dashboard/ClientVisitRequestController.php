<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\BookingQuery;
use App\Models\WebmasterSection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

    public function getUploadPath(string $subFolder = null)
    {
        $subFolder = $subFolder ?? 'misc';
        $basePath = base_path('../uploads/');
        $path = $basePath . $subFolder . '/';

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        return $path;
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

        DB::beginTransaction();

        try {
            $booking = BookingQuery::findOrFail($id);
            if($booking->nid_front_pic){
                $filePath = $this->getUploadPath('') . $booking->nid_front_pic;

                if (!empty($filePath) && file_exists($filePath) && is_file($filePath)) {
                    if (is_writable($filePath)) {
                        unlink($filePath);
                    }
                }
            }
            if($booking->nid_back_pic){
                $filePath = $this->getUploadPath('') . $booking->nid_back_pic;

                if (!empty($filePath) && file_exists($filePath) && is_file($filePath)) {
                    if (is_writable($filePath)) {
                        unlink($filePath);
                    }
                }
            }
            //  Delete DB row
            $booking->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Client Visit Request deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Something went wrong. Delete failed.');
        }
    }
}
