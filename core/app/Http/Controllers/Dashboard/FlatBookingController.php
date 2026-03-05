<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebmasterSection;
use App\Models\PriceModel;
use App\Models\Contact;
use App\Models\DocumentType;
use App\Models\MaterialType;
use App\Models\FlatBookingModel;
use App\Models\BookedFlatInfo;
use App\Models\FlatDocuments;
use App\Models\MaterialDetails;
use DB;
use Auth;
use File;
use Helper;

class FlatBookingController extends Controller
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
        $prices = PriceModel::with(['project', 'flat', 'customer'])->get();
        $flatBookingDetails = FlatBookingModel::with(['client', 'flatBookingDetails.projects', 'flatBookingDetails.flats', 'flatBookingDetails.flatDocuments', 'flatBookingDetails.materialDocuments'])->get();
        return view("dashboard.flat-booking.list", compact("prices", "flatBookingDetails", "GeneralWebmasterSections"));
    }
    public function getUploadPath(string $subFolder = null)
    {
        $subFolder = $subFolder ?? 'misc';
        $basePath = base_path('../uploads/');
        $path = $basePath . $subFolder;

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
        $contacts = Contact::where('status', 1)->get();
        $documentTypes = DocumentType::all();
        $materialTypes = MaterialType::all();
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        return view("dashboard.flat-booking.create", compact("GeneralWebmasterSections", "contacts", "documentTypes", "materialTypes"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'project_id.*' => 'required',
            'flat_id.*' => 'required',
            'is_negotiable_total_price.*' => 'nullable|boolean',
            'price_per_sqft.*' => 'nullable|numeric',
            'is_govt_gas_included.*' => 'nullable|numeric',
            'is_govt_gas_connection_paid.*' => 'nullable|numeric',
            'govt_gas_connection_payment_scheme.*' => 'nullable|string',
            'gas_amount.*' => 'nullable|numeric',
            'is_parking_included.*' => 'nullable|numeric',
            'is_parking_paid.*' => 'nullable|numeric',
            'parking_payment_scheme.*' => 'nullable|string',
            'parking_amount.*' => 'nullable|numeric',
            'is_utility_included.*' => 'nullable|numeric',
            'utility_payment_scheme.*' => 'nullable|string',
            'utility_amount.*' => 'nullable|numeric',
            'extras_amount.*' => 'nullable|numeric',
            'is_discount_applicable.*' => 'nullable|numeric',
            'discount_amount.*' => 'nullable|numeric',
            'total_price_flat.*' => 'required|numeric',
            'emi_amount_flat.*' => 'nullable|numeric',
            'emi_start_date_flat.*' => 'nullable|date',
            'document_type_id.*.*' => 'nullable|integer',
            'document.*.*' => 'nullable|file|max:10240',
            'material_type_id.*.*' => 'nullable|integer',
            'material_details.*.*' => 'nullable|string',
            'material_document.*.*' => 'nullable|file|max:10240',
            'is_discount_applicable_total' => 'nullable|numeric',
            'discount_amount_total' => 'nullable|numeric',
            'total_price' => 'required|numeric',
            'booking_amount' => 'required|numeric',
            'downpayment_amount' => 'required|numeric',
            'extras_amount_total' => 'nullable|numeric',
            'due_amount' => 'nullable|numeric',
            'emi_amount' => 'required|numeric',
            'emi_count' => 'required|numeric|min:1',
            'is_emi_date_combined' => 'nullable|numeric',
            'emi_start_date' => 'nullable|date',
        ]);
        DB::transaction(function () use ($request) {
            $FlatBooking = FlatBookingModel::create([
                'client_id' => $request->customer_id,
                'is_discount_applicable_total' => $request->is_discount_applicable_total,
                'discount_amount_total' => $request->discount_amount_total,
                'total_price' => $request->total_price,
                'booking_amount' => $request->booking_amount,
                'downpayment_amount' => $request->downpayment_amount,
                'extras_total' => $request->extras_amount_total,
                'due_amount_total' => $request->due_amount,
                'total_emi_amount' => $request->emi_amount,
                'emi_count' => $request->emi_count,
                'is_emi_date_combined' => $request->is_emi_date_combined,
                'emi_start_date' => $request->emi_start_date,
            ]);

            $booking_id = $FlatBooking->id;
            $FlatBookingMap = [];
            foreach ($request->project_id as $index => $projectId) {
                $flatId = $request->flat_id[$index];
                $flatDetails = BookedFlatInfo::create([
                    'booking_id' => $booking_id,
                    'project_id' => $projectId,
                    'flat_id' => $flatId,
                    'flat_size' => $request->flat_size[$index] ?? 0,
                    'is_negotiate_total_price' => $request->is_negotiable_total_price[$index] ?? 0,
                    'price_per_sqft' => $request->price_per_sqft[$index] ?? 0,
                    'is_govt_gas_included' => $request->is_govt_gas_included[$index] ?? 0,
                    'is_govt_gas_connection_paid' => $request->is_govt_gas_connection_paid[$index] ?? 0,
                    'govt_gas_payment_scheme' => $request->govt_gas_connection_payment_scheme[$index] ?? null,
                    'gas_connection_fee' => $request->gas_amount[$index] ?? 0,
                    'is_parking_included' => $request->is_parking_included[$index] ?? 0,
                    'is_parking_paid' => $request->is_parking_paid[$index] ?? 0,
                    'parking_payment_scheme' => $request->parking_payment_scheme[$index] ?? null,
                    'parking_fee' => $request->parking_amount[$index] ?? 0,
                    'is_utility_included' => $request->is_utility_included[$index] ?? 0,
                    'utility_payment_scheme' => $request->utility_payment_scheme[$index] ?? null,
                    'utility_fee' => $request->utility_amount[$index] ?? 0,
                    'extras_amount' => $request->extras_amount[$index] ?? 0,
                    'is_applicable_discount' => $request->is_discount_applicable[$index] ?? 0,
                    'discounted_amount' => $request->discount_amount[$index] ?? 0,
                    'total_price_flat' => $request->total_price_flat[$index],
                    'emi_amount_flat' => $request->emi_amount_flat[$index] ?? 0,
                    'emi_start_date_flat' => $request->emi_start_date_flat[$index] ?? null,
                ]);
                $FlatBookingMap[$flatId] = [
                    'booked_flat_id' => $flatDetails->id,
                    'project_id' => $projectId
                ];
            }
            /* ===============================
            Flat Documents (per flat)
            =============================== */
            if ($request->has('document_type_id')) {

                foreach ($request->document_type_id as $flatId => $docTypes) {

                    if (!isset($FlatBookingMap[$flatId])) {
                        continue;
                    }
                    foreach ($docTypes as $index => $documentTypeId) {

                        $file = $request->file("document.$flatId.$index");
                        if (!$file) {
                            continue;
                        }
                        $path = $this->getUploadPath('flat_documents_client');

                        $fileName = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
                        $file->move($path, $fileName);

                        Helper::imageResize($path . $fileName);
                        Helper::imageOptimize($path . $fileName);
                        FlatDocuments::create([
                            'booking_id' => $booking_id,
                            'booked_flat_id' => $FlatBookingMap[$flatId]['booked_flat_id'],
                            'project_id' => $FlatBookingMap[$flatId]['project_id'],
                            'flat_id' => $flatId,
                            'document_type_id' => $documentTypeId,
                            'file_path' => 'flat_documents_client/' . $fileName,
                        ]);
                    }
                }
            }
            /* ===============================
             Materials (per flat)
            =============================== */
            if ($request->has('material_type_id')) {

                foreach ($request->material_type_id as $flatId => $materials) {

                    if (!isset($FlatBookingMap[$flatId])) {
                        continue;
                    }


                    foreach ($materials as $index => $materialTypeId) {

                        $file = $request->file("material_document.$flatId.$index");

                        // skip if no material type
                        if (!$materialTypeId) {
                            continue;
                        }

                        $fileName = null;

                        if ($file) {
                            $path = $this->getUploadPath('material_documents_client');

                            $fileName = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
                            $file->move($path, $fileName);

                            // optional image processing
                            Helper::imageResize($path . $fileName);
                            Helper::imageOptimize($path . $fileName);
                        }

                        MaterialDetails::create([
                            'booking_id' => $booking_id,
                            'booked_flat_id' => $FlatBookingMap[$flatId]['booked_flat_id'],
                            'project_id' => $FlatBookingMap[$flatId]['project_id'],
                            'flat_id' => $flatId,
                            'material_type_id' => $materialTypeId,
                            'details' => $request->material_details[$flatId][$index] ?? null,
                            'material_document' => 'material_documents_client/' . $fileName,
                        ]);
                    }
                }
            }
        });
        return redirect()
            ->route('flat-booking')
            ->with('success', 'Flat Booking created successfully!');
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
        $booking = FlatBookingModel::with(['client', 'flatBookingDetails.projects', 'flatBookingDetails.flats', 'flatBookingDetails.flatDocuments', 'flatBookingDetails.materialDocuments'])->findOrFail($id);
        // dd($booking->flatBookingDetails);
        $contacts = Contact::where('status', 1)->get();
        $documentTypes = DocumentType::all();
        $materialTypes = MaterialType::all();
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        return view("dashboard.flat-booking.edit", compact("GeneralWebmasterSections", "booking", "contacts", "documentTypes", "materialTypes"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required',
            'project_id.*' => 'required',
            'flat_id.*' => 'required',
            'total_price_flat.*' => 'required|numeric',
            'total_price' => 'required|numeric',
            'booking_amount' => 'required|numeric',
            'downpayment_amount' => 'required|numeric',
            'emi_amount' => 'required|numeric',
            'emi_count' => 'required|numeric|min:1',
        ]);

        DB::transaction(function () use ($request, $id) {

            $FlatBooking = FlatBookingModel::findOrFail($id);

            /* ===============================
            UPDATE MAIN BOOKING
            =============================== */
            $FlatBooking->update([
                'client_id' => $request->customer_id,
                'is_discount_applicable_total' => $request->is_discount_applicable_total ?? 0,
                'discount_amount_total' => $request->discount_amount_total ?? 0,
                'total_price' => $request->total_price,
                'booking_amount' => $request->booking_amount,
                'downpayment_amount' => $request->downpayment_amount,
                'extras_total' => $request->extras_amount_total ?? 0,
                'due_amount_total' => $request->due_amount ?? 0,
                'total_emi_amount' => $request->emi_amount,
                'emi_count' => $request->emi_count,
                'is_emi_date_combined' => $request->is_emi_date_combined ?? 0,
                'emi_start_date' => $request->emi_start_date,
            ]);

            $booking_id = $FlatBooking->id;

            /* ===============================
            DELETE OLD CHILD DATA
            =============================== */
            $existingFlats = BookedFlatInfo::where('booking_id', $booking_id)
                ->get()
                ->keyBy('flat_id');

            $requestFlatIds = [];
            $FlatBookingMap = [];

            /* ===============================
            CREATE / UPDATE FLATS
            =============================== */

            foreach ($request->project_id as $index => $projectId) {

                $flatId = $request->flat_id[$index];
                $requestFlatIds[] = $flatId;

                $flatData = [
                    'project_id' => $projectId,
                    'flat_id' => $flatId,
                    'flat_size' => $request->flat_size[$index] ?? 0,
                    'is_negotiate_total_price' => $request->is_negotiable_total_price[$index] ?? 0,
                    'price_per_sqft' => $request->price_per_sqft[$index] ?? 0,
                    'is_govt_gas_included' => $request->is_govt_gas_included[$index] ?? 0,
                    'is_govt_gas_connection_paid' => $request->is_govt_gas_connection_paid[$index] ?? 0,
                    'govt_gas_payment_scheme' => $request->govt_gas_connection_payment_scheme[$index] ?? null,
                    'gas_connection_fee' => $request->gas_amount[$index] ?? 0,
                    'is_parking_included' => $request->is_parking_included[$index] ?? 0,
                    'is_parking_paid' => $request->is_parking_paid[$index] ?? 0,
                    'parking_payment_scheme' => $request->parking_payment_scheme[$index] ?? null,
                    'parking_fee' => $request->parking_amount[$index] ?? 0,
                    'is_utility_included' => $request->is_utility_included[$index] ?? 0,
                    'utility_payment_scheme' => $request->utility_payment_scheme[$index] ?? null,
                    'utility_fee' => $request->utility_amount[$index] ?? 0,
                    'extras_amount' => $request->extras_amount[$index] ?? 0,
                    'is_applicable_discount' => $request->is_discount_applicable[$index] ?? 0,
                    'discounted_amount' => $request->discount_amount[$index] ?? 0,
                    'total_price_flat' => $request->total_price_flat[$index] ?? 0,
                    'emi_amount_flat' => $request->emi_amount_flat[$index] ?? 0,
                    'emi_start_date_flat' => $request->emi_start_date_flat[$index] ?? null,
                ];

                if (isset($existingFlats[$flatId])) {

                    $existingFlats[$flatId]->update($flatData);
                    $flatDetails = $existingFlats[$flatId];

                } else {

                    $flatData['booking_id'] = $booking_id;
                    $flatDetails = BookedFlatInfo::create($flatData);
                }

                $FlatBookingMap[$flatId] = [
                    'booked_flat_id' => $flatDetails->id,
                    'project_id' => $projectId
                ];
            }


            /* ===============================
            DELETE REMOVED FLATS
            =============================== */

            foreach ($existingFlats as $flatId => $flat) {

                if (!in_array($flatId, $requestFlatIds)) {

                    $documents = FlatDocuments::where('booked_flat_id', $flat->id)->get();

                    foreach ($documents as $doc) {

                        $filePath = $this->getUploadPath('') . $doc->file_path;

                        if ($doc->file_path && file_exists($filePath)) {
                            unlink($filePath);
                        }

                        $doc->delete();
                    }

                    $materials = MaterialDetails::where('booked_flat_id', $flat->id)->get();

                    foreach ($materials as $material) {

                        $filePath = $this->getUploadPath('') . $material->material_document;

                        if ($material->material_document && file_exists($filePath)) {
                            unlink($filePath);
                        }

                        $material->delete();
                    }

                    $flat->delete();
                }
            }

            /* ===============================
            SMART DOCUMENT UPDATE
            =============================== */

            foreach ($FlatBookingMap as $flatId => $flatInfo) {

                // $existingDocs = FlatDocuments::where('booking_id', $booking_id)
                //     ->where('flat_id', $flatId)
                //     ->get()
                //     ->keyBy('id');
                $existingDocs = FlatDocuments::where('booked_flat_id', $flatInfo['booked_flat_id'])
                    ->get()
                    ->keyBy('id');

                $requestDocIds = [];
                if (isset($request->document_type_id[$flatId])) {
                    // dd($flatId);
                    foreach ($request->document_type_id[$flatId] as $index => $documentTypeId) {

                        $docId = $request->document_id[$flatId][$index] ?? null;
                        $file  = $request->file("document.$flatId.$index");
                        // If existing document
                        if ($docId && isset($existingDocs[$docId])) {

                            $document = $existingDocs[$docId];
                            $requestDocIds[] = intval($docId);


                            // Update document type if selected
                            if ($documentTypeId) {
                                $document->document_type_id = $documentTypeId;
                            }

                            // Replace file only if new file uploaded
                            if ($file) {
                                $filePath = $this->getUploadPath('') . $document->file_path;
                                if ($document->file_path &&
                                    file_exists($filePath)) {
                                    unlink($filePath);
                                }

                                $path = $this->getUploadPath('flat_documents_client');
                                $fileName = time().rand(1111,9999).'.'.$file->getClientOriginalExtension();
                                $file->move($path, $fileName);

                                $document->file_path = 'flat_documents_client/'.$fileName;
                            }

                            $document->save();

                        }
                        // New document
                        elseif ($documentTypeId && $file) {

                            $path = $this->getUploadPath('flat_documents_client');
                            $fileName = time().rand(1111,9999).'.'.$file->getClientOriginalExtension();
                            $file->move($path, $fileName);

                            $newDoc = FlatDocuments::create([
                                'booking_id' => $booking_id,
                                'booked_flat_id' => $flatInfo['booked_flat_id'],
                                'project_id' => $flatInfo['project_id'],
                                'flat_id' => $flatId,
                                'document_type_id' => $documentTypeId,
                                'file_path' => 'flat_documents_client/'.$fileName,
                            ]);
                            $requestDocIds[] = intval($newDoc->id);
                        }
                    }
                }
                    // dd([$existingDocs, $requestDocIds]);

                // Only delete if user actually removed row
                foreach ($existingDocs as $docId => $doc) {
                    $filePath = $this->getUploadPath('') . $doc->file_path;
                    $docId = intval($docId);
                    // dd([$docId, $requestDocIds]);
                    if (!in_array($docId, $requestDocIds)) {
                        if ($doc->file_path && file_exists($filePath)) {
                            unlink($filePath);
                        }
                        $doc->delete();
                    }
                }
            }

            /* ===============================
            SMART MATERIAL UPDATE
            =============================== */

            foreach ($FlatBookingMap as $flatId => $flatInfo) {

                $existingMaterials = MaterialDetails::where('booking_id', $booking_id)
                    ->where('flat_id', $flatId)
                    ->get()
                    ->keyBy('id');

                $requestMaterialIds = [];

                if (isset($request->material_type_id[$flatId])) {

                    foreach ($request->material_type_id[$flatId] as $index => $materialTypeId) {

                        if (!$materialTypeId) continue;

                        $materialId = $request->material_id[$flatId][$index] ?? null;
                        $file = $request->file("material_document.$flatId.$index");

                        if ($materialId && isset($existingMaterials[$materialId])) {

                            $material = $existingMaterials[$materialId];
                            $requestMaterialIds[] = intval($materialId);

                            if ($file) {

                                // Correct absolute path
                                if ($material->material_document) {

                                    $oldPath = $this->getUploadPath('material_documents_client')
                                            . '/' .
                                            basename($material->material_document);

                                    if (file_exists($oldPath)) {
                                        unlink($oldPath);
                                    }
                                }

                                $path = $this->getUploadPath('material_documents_client');
                                $fileName = time().rand(1111,9999).'.'.$file->getClientOriginalExtension();
                                $file->move($path, $fileName);

                                $material->material_document =
                                    'material_documents_client/'.$fileName;
                            }

                            $material->material_type_id = $materialTypeId;
                            $material->details = $request->material_details[$flatId][$index] ?? null;
                            $material->save();
                        } else {

                            $fileName = null;

                            if ($file) {
                                $path = $this->getUploadPath('material_documents_client');
                                $fileName = time().rand(1111,9999).'.'.$file->getClientOriginalExtension();
                                $file->move($path, $fileName);
                            }

                            $newMaterial = MaterialDetails::create([
                                'booking_id' => $booking_id,
                                'booked_flat_id' => $flatInfo['booked_flat_id'],
                                'project_id' => $flatInfo['project_id'],
                                'flat_id' => $flatId,
                                'material_type_id' => $materialTypeId,
                                'details' => $request->material_details[$flatId][$index] ?? null,
                                'material_document' => $fileName
                                    ? 'material_documents_client/'.$fileName
                                    : null,
                            ]);

                            $requestMaterialIds[] = $newMaterial->id;
                        }
                    }
                }

                // DELETE REMOVED MATERIAL + FILE
                foreach ($existingMaterials as $materialId => $material) {

                    $materialId = intval($materialId);

                    if (!in_array($materialId, $requestMaterialIds)) {

                        if ($material->material_document) {

                            $filePath = $this->getUploadPath('material_documents_client')
                                        . '/' .
                                        basename($material->material_document);

                            if (file_exists($filePath)) {
                                unlink($filePath);
                            }
                        }

                        $material->delete();
                    }
                }
            }
        });

        return redirect()
            ->route('flat-booking')
            ->with('success', 'Flat Booking updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $booking = FlatBookingModel::with([
                'flatBookingDetails.flatDocuments',
                'flatBookingDetails.materialDocuments'
            ])->findOrFail($id);
            // dd($booking);

            foreach ($booking->flatBookingDetails as $flatDetail) {
                foreach ($flatDetail->flatDocuments as $doc) {
                    $path = $this->getUploadPath('') . $doc->file_path;
                    if(file_exists($path)) {
                        unlink($path);
                    }
                    $doc->delete();
                }

                foreach ($flatDetail->materialDocuments as $mat) {
                    $path = $this->getUploadPath('') . $mat->material_document;
                    if(file_exists($path)) {
                        unlink($path);
                    }
                    $mat->delete();
                }

                $flatDetail->delete();
            }

            $booking->delete();

            DB::commit();

            return redirect()
            ->route('flat-booking')
            ->with('success', 'Flat Booking deleted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Delete failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
