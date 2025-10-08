<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentType;
use App\Models\WebmasterSection;
use Auth;

class DocumentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        $documentTypes = DocumentType::all();
        return view("dashboard.document-type.list", compact("GeneralWebmasterSections", "documentTypes"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        return view('dashboard.document-type.create', compact("GeneralWebmasterSections"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string|unique:document_types,document_type',
        ]);

        DocumentType::create([
            'document_type' => $request->document_type,
        ]);

        return redirect()->route('document-type')->with('success', 'Document Type created successfully!');
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
        $documentType = DocumentType::findOrFail($id);
        return view('dashboard.document-type.edit', compact('documentType', 'GeneralWebmasterSections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $documentType = DocumentType::findOrFail($id);
        $request->validate([
            'document_type' => 'required|string|unique:document_types,document_type,' . $documentType->id,
        ]);

        $documentType->update([
            'document_type' => $request->document_type,
        ]);

        return redirect()->route('document-type')->with('success', 'Document Type updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $documentType = DocumentType::findOrFail($id);
        $documentType->delete();
        return redirect()->route('document-type')->with('success', 'Document Type deleted successfully!');
    }
}
