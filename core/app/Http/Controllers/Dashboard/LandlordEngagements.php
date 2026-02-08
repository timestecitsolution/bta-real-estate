<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Helpers\Helper;
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
use App\Models\LandlordFacilities;
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
        // dd($engagements);
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
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|integer',
            'project_document_type_id.*' => 'nullable|integer',
            'project_document.*'         => 'nullable|file|max:10240',
            'number_of_parking' => 'nullable|integer',
            'number_of_gas_connection' => 'nullable|integer',
            'number_of_utility' => 'nullable|integer',

            'landlord_id.*' => 'required|integer',
            'flat_id.*'     => 'required|integer',

            'flat_document_type_id.*.*' => 'nullable|integer',
            'flat_document.*.*'         => 'nullable|file|max:10240',

            'material_type_id.*.*'  => 'nullable|integer',
            'material_details.*.*'  => 'nullable|string',
            'material_document.*.*' => 'nullable|file|max:10240',
        ]);

        DB::transaction(function () use ($request) {

            LandlordFacilities::create([
                'project_id'        => $request->project_id,
                'number_of_parking'  => $request->number_of_parking ?? 0,
                'number_of_gas_connection' => $request->number_of_gas_connection ?? 0,
                'number_of_utility' => $request->number_of_utility ?? 0,
            ]);
            /* ===============================
            0️⃣ Project Documents
            =============================== */
            if ($request->has('project_document_type_id')) {

                foreach ($request->project_document_type_id as $index => $docTypeId) {

                    if (!$docTypeId) {
                        continue;
                    }

                    $file = $request->file("project_document.$index");

                    if (!$file) {
                        continue;
                    }

                    $path = $this->getUploadPath('project_documents_landlord');

                    $fileName = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
                    $file->move($path, $fileName);

                    EngagementProjectDocument::create([
                        'project_id'        => $request->project_id,
                        'document_type_id'  => $docTypeId,
                        'file_path'         => 'project_documents_landlord/' . $fileName,
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

                //  flat_id => engagement_id
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

                        if (!$docTypeId) {
                            continue;
                        }

                        $file = $request->file("flat_document.$flatId.$index");

                        if (!$file) {
                            continue;
                        }

                        $path = $this->getUploadPath('flat_documents_landlord');

                        $fileName = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
                        $file->move($path, $fileName);

                        Helper::imageResize($path . $fileName);
                        Helper::imageOptimize($path . $fileName);

                        EngagementFlatDocument::create([
                            'engagement_id'    => $engagementId,
                            'document_type_id' => $docTypeId,
                            'file_path'        => 'flat_documents_landlord/' . $fileName,
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

                        $file = $request->file("material_document.$flatId.$index");

                        // skip if no material type
                        if (!$materialTypeId) {
                            continue;
                        }

                        $fileName = null;

                        if ($file) {
                            $path = $this->getUploadPath('material_documents_landlord');

                            $fileName = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
                            $file->move($path, $fileName);

                            // optional image processing
                            Helper::imageResize($path . $fileName);
                            Helper::imageOptimize($path . $fileName);
                        }

                        EngagementMaterial::create([
                            'engagement_id'      => $engagementId,
                            'material_type_id'   => $materialTypeId,
                            'material_details'   => $request->material_details[$flatId][$index] ?? null,
                            'material_documents' => 'material_documents_landlord/' . $fileName,
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
            EngagementProjectDocument::whereIn('id', $request->removed_project_docs ?? [])->delete();
            EngagementFlatDocument::whereIn('id', $request->removed_flat_docs ?? [])->delete();
            EngagementMaterial::whereIn('id', $request->removed_materials ?? [])->delete();
            LandlordEngagement::whereIn('id', $request->removed_engagements ?? [])->delete();

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
                if (!$file) {
                    continue;
                }

                $path = $this->getUploadPath('project_documents_landlord');

                $fileName = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
                $file->move($path, $fileName);

                EngagementProjectDocument::updateOrCreate(
                    [
                        'project_id'       => $projectId,
                        'document_type_id' => $typeId,
                    ],
                    [
                        'file_path' => $file
                            ? 'project_documents_landlord/' . $fileName
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
             FLAT DOCUMENTS
            =============================== */
            foreach ($request->flat_document_type_id ?? [] as $flatId => $types) {

                if (!isset($engagementMap[$flatId])) continue;

                foreach ($types as $idx => $typeId) {

                    if (!$typeId) continue;

                    $file = $request->file("flat_document.$flatId.$idx");

                    if (!$file) {
                        continue;
                    }

                    $path = $this->getUploadPath('flat_documents_landlord');

                    $fileName = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
                    $file->move($path, $fileName);

                    EngagementFlatDocument::updateOrCreate(
                        [
                            'engagement_id'    => $engagementMap[$flatId],
                            'document_type_id' => $typeId,
                        ],
                        [
                            'file_path' => $file
                                ? 'flat_documents_landlord/' . $fileName
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
                    if (!$file) {
                        continue;
                    }

                    $path = $this->getUploadPath('material_documents_landlord');

                    $fileName = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
                    $file->move($path, $fileName);

                    EngagementMaterial::updateOrCreate(
                        [
                            'engagement_id'    => $engagementMap[$flatId],
                            'material_type_id' => $typeId,
                        ],
                        [
                            'material_details'   => $request->material_details[$flatId][$idx] ?? null,
                            'material_documents' => $file
                                ? 'material_documents_landlord/' . $fileName
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
        // ===============================
        // 1️⃣ Collect all file paths first
        // ===============================
        $filesToDelete = [];

        $projectDocs = EngagementProjectDocument::where('project_id', $projectId)->get();
        foreach ($projectDocs as $doc) {
            if ($doc->file_path) {
                $filesToDelete[] = $doc->file_path;
            }
        }

        $engagements = LandlordEngagement::with(['flatDocuments', 'materials'])
            ->where('project_id', $projectId)
            ->get();

        foreach ($engagements as $eng) {

            foreach ($eng->flatDocuments as $flatDoc) {
                if ($flatDoc->file_path) {
                    $filesToDelete[] = $flatDoc->file_path;
                }
            }

            foreach ($eng->materials as $material) {
                if ($material->material_documents) {
                    $filesToDelete[] = $material->material_documents;
                }
            }
        }
        // ===============================
        //  DB Transaction
        // ===============================
        DB::beginTransaction();

        try {

            LandlordFacilities::where('project_id', $projectId)->delete();
            EngagementProjectDocument::where('project_id', $projectId)->delete();

            foreach ($engagements as $eng) {
                $eng->flatDocuments()->delete();
                $eng->materials()->delete();
            }

            LandlordEngagement::where('project_id', $projectId)->delete();

            DB::commit();

        } catch (\Throwable $e) {

            DB::rollBack();

            \Log::error('Project delete failed', [
                'project_id' => $projectId,
                'error' => $e->getMessage(),
            ]);

            return back()->withErrors(['error' => 'Delete failed.']);
        }

        // ===============================
        // 3️⃣ Delete files AFTER DB commit
        // ===============================
        foreach ($filesToDelete as $file) {
            $fullPath = base_path('../uploads/' . $file);

            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }
        }

        return back()->with('success', 'Project, engagements & all files deleted successfully');
    }
}
