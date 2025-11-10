<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaterialDetails;

class MaterialDetailsController extends Controller
{
    public function MaterialChangeApplication(Request $request, $id)
    {
        $request->validate([
            'change_details' => 'required|string|max:5000',
        ]);

        $material = MaterialDetails::findOrFail($id);

        $material->change_details = $request->change_details;
        $material->status = 'pending'; 
        $material->save();

        return back()->with('success', 'Material change request submitted successfully!');
    }
    public function MaterialChangeApproval(Request $request, $id)
    {
        $request->validate([
            'admin_status' => 'required|in:approved,rejected',
            'admin_note' => 'nullable|string|max:20000',
        ]);

        $material = MaterialDetails::findOrFail($id);

        $material->status = $request->admin_status;
        $material->admin_note = $request->admin_note;
        $material->save();

        return back()->with('success', 'Material change request has been ' . $request->admin_status . '.');
    }
}
