<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaterialType;
use App\Models\WebmasterSection;

class MaterialTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        $materialTypes = MaterialType::all();
        return view("dashboard.material-type.list", compact("GeneralWebmasterSections", "materialTypes"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        return view('dashboard.material-type.create', compact("GeneralWebmasterSections"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'material_type' => 'required|string|unique:material_types,material_type',
        ]);

        MaterialType::create([
            'material_type' => $request->material_type,
        ]);

        return redirect()->route('material-type')->with('success', 'Material Type created successfully!');
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
        $materialType = MaterialType::findOrFail($id);
        return view('dashboard.material-type.edit', compact('materialType', 'GeneralWebmasterSections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $materialType = MaterialType::findOrFail($id);
        $request->validate([
            'material_type' => 'required|string|unique:material_types,material_type,' . $materialType->id,
        ]);

        $materialType->update([
            'material_type' => $request->material_type,
        ]);

        return redirect()->route('material-type')->with('success', 'Material Type updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $materialType = MaterialType::findOrFail($id);
        $materialType->delete();
        return redirect()->route('material-type')->with('success', 'Material Type deleted successfully!');
    }
}
