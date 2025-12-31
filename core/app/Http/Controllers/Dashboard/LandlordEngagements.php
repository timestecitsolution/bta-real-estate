<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PriceModel;
use App\Models\WebmasterSection;
use App\Models\Contact;
use App\Models\DocumentType;
use App\Models\MaterialType;
use App\Models\LandlordEngagement;
use App\Models\EngagementProjectDocument;;
use App\Models\EngagementFlatDocument;
use App\Models\EngagementMaterial;
use App\Models\Topic;
use Auth;

class LandlordEngagements extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check Permissions
        $data_sections_arr = explode(",", Auth::user()->permissionsGroup->data_sections);
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        $engagements = LandlordEngagement::with(['project','flat','customer', 'flatDocuments','materials'])->orderBy('id','DESC')->get();
        // General END
        return view("dashboard.landlord-engagements.list", compact("GeneralWebmasterSections", "engagements"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contacts = Contact::where('status', 2)->get();
        $documentTypes = DocumentType::all();
        $materialTypes = MaterialType::all();
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        return view("dashboard.landlord-engagements.create", compact("GeneralWebmasterSections", "contacts", "documentTypes", "materialTypes"));
    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|integer',
            'project_document_type_id.*' => 'nullable|integer',
            'project_document.*'         => 'nullable|file|max:10240',

            'landlord_id.*' => 'required|integer',
            'flat_id.*'     => 'required|integer',

            'flat_document_type_id.*.*' => 'nullable|integer',
            'flat_document.*.*'         => 'nullable|file|max:10240',

            'material_type_id.*.*'  => 'nullable|integer',
            'material_details.*.*'  => 'nullable|string',
            'material_document.*.*' => 'nullable|file|max:10240',
        ]);

        DB::transaction(function () use ($request) {

            /* ===============================
            0️⃣ Project Documents
            =============================== */
            if ($request->has('project_document_type_id')) {

                foreach ($request->project_document_type_id as $index => $docTypeId) {

                    if (!$docTypeId) continue;

                    $file = $request->file("project_document.$index");
                    if (!$file) continue;

                    EngagementProjectDocument::create([
                        'project_id'        => $request->project_id,
                        'document_type_id'  => $docTypeId,
                        'file_path'  => $file->store(
                            'uploads/project_documents',
                            'public'
                        ),
                    ]);
                }
            }


            /* ===============================
            1️⃣ Create Engagements
            =============================== */
            $engagementMap = []; 

            foreach ($request->landlord_id as $i => $landlordId) {

                $flatId = $request->flat_id[$i] ?? null;
                if (!$landlordId || !$flatId) {
                    continue;
                }

                $engagement = LandlordEngagement::create([
                    'project_id'  => $request->project_id,
                    'landlord_id' => $landlordId,
                    'flat_id'     => $flatId,
                ]);

                // 🔑 flat_id => engagement_id
                $engagementMap[$flatId] = $engagement->id;
            }

            /* ===============================
            2️⃣ Flat Documents (per flat)
            =============================== */
            if ($request->has('flat_document_type_id')) {

                foreach ($request->flat_document_type_id as $flatId => $docTypes) {

                    if (!isset($engagementMap[$flatId])) {
                        continue;
                    }

                    $engagementId = $engagementMap[$flatId];

                    foreach ($docTypes as $index => $docTypeId) {

                        if (!$docTypeId) continue;

                        $file = $request->file("flat_document.$flatId.$index");
                        if (!$file) continue;

                        EngagementFlatDocument::create([
                            'engagement_id'    => $engagementId,
                            'document_type_id' => $docTypeId,
                            'file_path'    => $file->store(
                                'uploads/flat_documents',
                                'public'
                            ),
                        ]);
                    }
                }
            }

            /* ===============================
            3️⃣ Materials (per flat)
            =============================== */
            if ($request->has('material_type_id')) {

                foreach ($request->material_type_id as $flatId => $materials) {

                    if (!isset($engagementMap[$flatId])) {
                        continue;
                    }

                    $engagementId = $engagementMap[$flatId];

                    foreach ($materials as $index => $materialTypeId) {

                        if (!$materialTypeId) continue;

                        $file = $request->file("material_document.$flatId.$index");

                        EngagementMaterial::create([
                            'engagement_id'     => $engagementId,
                            'material_type_id'  => $materialTypeId,
                            'material_details'  => $request->material_details[$flatId][$index] ?? null,
                            'material_documents' => $file
                                ? $file->store('uploads/material_documents', 'public')
                                : null,
                        ]);
                    }
                }
            }
        });

        return redirect()
            ->route('landlordEngagements')
            ->with('success', 'Engagement successfully created!');
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
    public function edit($projectId)
    {
        $engagements = LandlordEngagement::with(['project','flat','customer', 'flatDocuments','materials'])
        ->where('project_id', $projectId)
        ->get();

        $project_documents = Topic::with('projectDocuments')->findOrFail($projectId);

        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();

        if ($engagements->isEmpty()) {
            abort(404);
        }

        return view("dashboard.landlord-engagements.edit", [
            'project'        => $engagements->first()->project,
            'engagements'    => $engagements,
            'contacts'       => Contact::all(),
            'materials'      => MaterialType::all(),
            'materialTypes'  => MaterialType::all(),
            'documentTypes'  => DocumentType::all(),
            'project_documents' => $project_documents->projectDocuments,
            'GeneralWebmasterSections' => $GeneralWebmasterSections,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $projectId = $id;
        DB::transaction(function () use ($request, $projectId) {

            /* ===============================
             DELETE REMOVED ITEMS
            =============================== */
            EngagementProjectDocument::whereIn(
                'id',
                $request->removed_project_docs ?? []
            )->delete();

            EngagementFlatDocument::whereIn(
                'id',
                $request->removed_flat_docs ?? []
            )->delete();

            EngagementMaterial::whereIn(
                'id',
                $request->removed_materials ?? []
            )->delete();

            LandlordEngagement::whereIn(
                'id',
                $request->removed_engagements ?? []
            )->delete();

            /* ===============================
            1️⃣ PROJECT DOCUMENTS (UPDATE / CREATE)
            =============================== */
            foreach ($request->project_document_type_id ?? [] as $i => $typeId) {

                if (!$typeId) continue;

                if (
                    isset($request->project_document_id[$i]) &&
                    in_array($request->project_document_id[$i], $request->removed_project_docs ?? [])
                ) {
                    continue;
                }

                $file = $request->file("project_document.$i");

                EngagementProjectDocument::updateOrCreate(
                    [
                        'project_id'       => $projectId,
                        'document_type_id' => $typeId,
                        'file_path'        => $file
                            ? $file->store('uploads/project_documents', 'public')
                            : $request->old_project_document[$i] ?? null
                    ]
                );
            }

            /* ===============================
            2️⃣ ENGAGEMENTS (UPDATE / CREATE)
            =============================== */
            $engagementMap = [];

            foreach ($request->landlord_id as $i => $landlordId) {

                $flatId = $request->flats[$i]['flat_id'] ?? null;
                if (!$flatId) continue;

                $engagement = LandlordEngagement::updateOrCreate(
                    [
                        'id' => $request->engagement_id[$i] ?? null
                    ],
                    [
                        'project_id'  => $projectId,
                        'landlord_id' => $landlordId,
                        'flat_id'     => $flatId,
                    ]
                );

                $engagementMap[$flatId] = $engagement->id;
            }


            /* ===============================
            3️⃣ FLAT DOCUMENTS
            =============================== */
            foreach ($request->flat_document_type_id ?? [] as $flatId => $types) {

                if (!isset($engagementMap[$flatId])) continue;

                foreach ($types as $idx => $typeId) {

                    if (!$typeId) continue;

                    $file = $request->file("flat_document.$flatId.$idx");

                    EngagementFlatDocument::updateOrCreate(
                        [
                            'engagement_id'    => $engagementMap[$flatId],
                            'document_type_id' => $typeId,
                        ],
                        [
                            'file_path' => $file
                                ? $file->store('uploads/flat_documents', 'public')
                                : $request->old_flat_document[$flatId][$idx] ?? null
                        ]
                    );
                }
            }



            /* ===============================
            4️⃣ MATERIALS
            =============================== */
            foreach ($request->material_type_id ?? [] as $flatId => $types) {

                if (!isset($engagementMap[$flatId])) continue;

                foreach ($types as $idx => $typeId) {

                    if (!$typeId) continue;

                    $file = $request->file("material_document.$flatId.$idx");

                    EngagementMaterial::updateOrCreate(
                        [
                            'engagement_id'    => $engagementMap[$flatId],
                            'material_type_id' => $typeId,
                        ],
                        [
                            'material_details'   => $request->material_details[$flatId][$idx] ?? null,
                            'material_documents' => $file
                                ? $file->store('uploads/material_documents', 'public')
                                : $request->old_material_document[$flatId][$idx] ?? null
                        ]
                    );
                }
            }


        });

        return redirect()
            ->route('landlordEngagements')
            ->with('success', 'Engagement updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($projectId)
    {
        DB::transaction(function () use ($projectId) {

            // ===============================
            // PROJECT DOCUMENTS
            // ===============================
            $projectDocs = EngagementProjectDocument::where('project_id', $projectId)->get();

            foreach ($projectDocs as $doc) {
                if ($doc->file_path && Storage::disk('public')->exists($doc->file_path)) {
                    Storage::disk('public')->delete($doc->file_path);
                }
            }

            EngagementProjectDocument::where('project_id', $projectId)->delete();

            // ===============================
            // ENGAGEMENTS
            // ===============================
            $engagements = LandlordEngagement::where('project_id', $projectId)->get();

            foreach ($engagements as $eng) {

                // ---------- Flat Documents ----------
                foreach ($eng->flatDocuments as $flatDoc) {
                    if ($flatDoc->file_path && Storage::disk('public')->exists($flatDoc->file_path)) {
                        Storage::disk('public')->delete($flatDoc->file_path);
                    }
                }
                EngagementFlatDocument::where('engagement_id', $eng->id)->delete();

                // ---------- Materials ----------
                foreach ($eng->materials as $material) {
                    if (
                        $material->material_documents &&
                        Storage::disk('public')->exists($material->material_documents)
                    ) {
                        Storage::disk('public')->delete($material->material_documents);
                    }
                }
                EngagementMaterial::where('engagement_id', $eng->id)->delete();
            }

            // ===============================
            // DELETE ENGAGEMENTS
            // ===============================
            LandlordEngagement::where('project_id', $projectId)->delete();
        });

        return back()->with('success', 'Project, engagements & all files deleted successfully');
    }


}
