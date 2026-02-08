<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebmasterSection;
use App\Models\MaterialType;
use App\Models\FlatDetailsModel;
use Illuminate\Support\Facades\DB;

class FlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        $flats = FlatDetailsModel::with('project')->get();
        return view("dashboard.flats.list", compact("GeneralWebmasterSections", "flats"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        return view('dashboard.flats.create', compact("GeneralWebmasterSections"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:topics,id',
            'flat_name' => 'required|string|max:255',
            'flat_size' => 'required|string|max:255',
        ]);
        $flatNames = array_filter(array_map('trim', explode(',', $request->flat_name)));

        DB::transaction(function () use ($request, $flatNames) {
            foreach ($flatNames as $flatName) {
                FlatDetailsModel::create([
                    'project_id' => $request->project_id,
                    'flat_name'  => $flatName,
                    'flat_size'  => $request->flat_size,
                ]);
            }
        });

        return redirect()
            ->route('flats')
            ->with('success', 'Flats created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        $flat = FlatDetailsModel::with('project')->findOrFail($id);
        return view('dashboard.flats.edit', compact('flat', 'GeneralWebmasterSections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'project_id' => 'required|exists:topics,id',
            'flat_name' => 'required|string|max:255',
            'flat_size' => 'required|string|max:255',
        ]);

        $flat = FlatDetailsModel::findOrFail($id);
        $flat->update([
            'project_id' => $request->input('project_id'),
            'flat_name' => $request->input('flat_name'),
            'flat_size' => $request->input('flat_size'),
        ]);

        return redirect()->route('flats')->with('success', 'Flat updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $flat = FlatDetailsModel::findOrFail($id);
            $flat->delete();

            DB::commit();

            return redirect()
                ->route('flats')
                ->with('success', 'Flat deleted successfully.');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->route('flats')
                ->with('error', 'Something went wrong while deleting the flat.');
        }
    }
}
