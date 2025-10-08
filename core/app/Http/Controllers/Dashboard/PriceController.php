<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Section;
use App\Models\Topic;
use App\Models\TopicCategory;
use App\Models\WebmasterSection;
use App\Models\Contact;
use App\Models\PriceModel;
use App\Models\DocumentType;
use App\Models\FlatDocuments;
use App\Models\Invoices;
use App\Models\EmiPayment;
use App\Http\Controllers\SMSService;
use Auth;
use File;
use Helper;
use Illuminate\Http\Request;
use Redirect;

class PriceController extends Controller
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
        // General END
        // $prices = PriceModel::all();
        $prices = PriceModel::with(['project', 'flat', 'customer'])->get();
        return view("dashboard.price.list", compact("prices", "GeneralWebmasterSections"));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($webmasterId = 8)
    {
        // $contacts = Contact::all();
        $contacts = Contact::where('status', 1)->get();
        $documentTypes = DocumentType::all();
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        return view("dashboard.price.create", compact("GeneralWebmasterSections", "contacts", "documentTypes"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|max:255',
            'flat_id' => 'required|numeric',
            'flat_size' => 'required|numeric',
            'customer_id' => 'required|string',
            'is_negotiable_total_price' => 'nullable|in:0,1',
            'price_per_sqft' => [
                'nullable', 
                'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('is_negotiable_total_price') == 0 && empty($value)) {
                        $fail('The '.$attribute.' field is required when negotiation is not selected.');
                    }
                }
            ],
            'price' => 'required|numeric',
            'emi' => 'required|string',
            'booking_amount' => 'required|string',
            'downpayment_amount' => 'required|string',
            'due_amount' => 'required|string',
            'emi_count' => 'required|string',
            'emi_start_date' => 'required|string',
            'is_applicable_govt_gas' => 'nullable|boolean',
            'is_govt_gas_connection_paid' => 'nullable|boolean',
            'govt_gas_connection_payment_scheme' => 'nullable|string',
            'gas_amount' => 'nullable|numeric',
            'is_applicable_parking' => 'nullable|boolean',
            'is_parking_paid' => 'nullable|boolean',
            'parking_payment_scheme' => 'nullable|string',
            'parking_amount' => 'nullable|numeric',
            'is_utility_included' => 'nullable|boolean',
            'utility_payment_scheme' => 'nullable|string',
            'utility_amount' => 'nullable|numeric',
            'extras_amount' => 'nullable|numeric',
            'is_discount_applicable' => 'nullable|boolean',
            'discount_amount' => 'nullable|numeric',
            'document_type_id.*' => 'nullable|exists:document_types,id',
            'document.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240|required_with:document_type_id.*',
        ]);
        $price = PriceModel::create($validated);

        // Handle multiple documents
        if ($request->has('document_type_id') && $request->hasFile('document')) {
            $folder = public_path('flat_document');
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }

            foreach ($request->document_type_id as $index => $docTypeId) {
                if ($docTypeId && isset($request->document[$index])) {
                    $file = $request->file('document')[$index];
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move($folder, $filename);

                    FlatDocuments::create([
                        'price_id' => $price->id,
                        'document_type_id' => $docTypeId,
                        'file_path' => 'flat_document/' . $filename,
                    ]);
                }
            }
        }

        if ($price) {

            // =====================
            // Generate Invoice No
            // =====================
            $lastInvoice = Invoices::orderBy('id', 'desc')->first();
            $nextInvoiceNo = $lastInvoice ? $lastInvoice->id + 1 : 1;
            $invoiceNo = 'INV-' . str_pad($nextInvoiceNo, 5, '0', STR_PAD_LEFT);

            // Insert into invoices table
            Invoices::create([
                'invoice_no'  => $invoiceNo,
                'payment_type'=> 'booking',
                'price_id'    => $price->id,
                'client_id'   => $validated['customer_id'],
                'total_price' => $validated['price'],
                'created_by'  => auth()->id(),
            ]);

            // Send SMS to customer
            $contacts = Contact::find($validated['customer_id']);
            $customerPhone = '88'.$contacts->phone; 
            $prices = PriceModel::find($price->id);
            $project = $prices->project;
            $message = "Dear {$contacts->first_name} {$contacts->last_name},\n"
                    . "Your flat booking is confirmed for the project: ({$project->title_en}),\n"
                    . "Flat No: ({$prices->flat->title}),\n"
                    . "Flat Size: {$validated['flat_size']} sq ft,\n"
                    . "Price (Per Sqft): " . number_format($validated['price_per_sqft']) . " BDT,\n"
                    . "Total Price: " . number_format($validated['price']) . " BDT,\n"
                    . "Booking Money: " . number_format($validated['booking_amount']) . " BDT,\n"
                    . "Downpayment: " . number_format($validated['downpayment_amount']) . " BDT,\n"
                    . "Due: " . number_format($validated['due_amount']) . " BDT,\n"
                    . "Total EMI: {$validated['emi_count']},\n"
                    . "EMI: " . number_format($validated['emi']) . " BDT (Per Month),\n"
                    . "1st EMI: " . date('d-m-Y', strtotime($validated['emi_start_date'])) . ".\n"
                    . "Thank you for choosing us.\n"
                    . "- Building Technology & Architecture.";

            // SMSService::send($customerPhone, $message);

            return redirect()->route('price')->with('success', 'Price added successfully!');
        }else {
            return redirect()->back()->with('error', 'Failed to add price. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $prices = PriceModel::find($id);
        $contacts = Contact::all();
        $projects = Helper::Topics(8); 

        if ($prices) {
            $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')
                ->orderby('row_no', 'asc')
                ->get();

            return view("dashboard.price.view", compact("prices", "contacts", "projects", "GeneralWebmasterSections"));
        } else {
            return redirect()->back()->with('error', 'Price not found.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $prices = PriceModel::find($id);
        $contacts = Contact::all();
        $projects = Helper::Topics(8); 
        $allDocumentTypes = DocumentType::all();
        $existingDocuments = FlatDocuments::where('price_id', $id)->get();
        $documentTypes = $allDocumentTypes->map(function ($docType) use ($existingDocuments) {
            $doc = $existingDocuments->firstWhere('document_type_id', $docType->id);
            $docType->file_path = $doc ? $doc->file_path : null;
            return $docType;
        });
        if ($prices) {
            $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')
                ->orderby('row_no', 'asc')
                ->get();

            return view("dashboard.price.edit", compact("prices", "contacts", "projects", "documentTypes", "allDocumentTypes", "existingDocuments", "GeneralWebmasterSections"));
        } else {
            return redirect()->back()->with('error', 'Price not found.');
        }
    }


    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $request->validate([
            'project_id' => 'required|max:255',
            'flat_id' => 'required|numeric',
            'flat_size' => 'required|numeric',
            'customer_id' => 'required|string',
            'is_negotiable_total_price' => 'nullable|in:0,1',
            'price_per_sqft' => [
                'nullable',
                'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('is_negotiable_total_price') == 0 && empty($value)) {
                        $fail('The '.$attribute.' field is required when negotiation is not selected.');
                    }
                }
            ],
            'price' => 'required|numeric',
            'emi' => 'required|string',
            'booking_amount' => 'required|string',
            'downpayment_amount' => 'required|string',
            'due_amount' => 'required|string',
            'emi_count' => 'required|string',
            'emi_start_date' => 'required|string',
            'is_applicable_govt_gas' => 'nullable|boolean',
            'is_govt_gas_connection_paid' => 'nullable|boolean',
            'govt_gas_connection_payment_scheme' => 'nullable|string',
            'gas_amount' => 'nullable|numeric',
            'is_applicable_parking' => 'nullable|boolean',
            'is_parking_paid' => 'nullable|boolean',
            'parking_payment_scheme' => 'nullable|string',
            'parking_amount' => 'nullable|numeric',
            'is_utility_included' => 'nullable|boolean',
            'utility_payment_scheme' => 'nullable|string',
            'utility_amount' => 'nullable|numeric',
            'extras_amount' => 'nullable|numeric',
            'is_discount_applicable' => 'nullable|boolean',
            'discount_amount' => 'nullable|numeric',
            'document_type_id.*' => 'nullable|exists:document_types,id',
            'document.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240|required_with:document_type_id.*',
        ]);
        $price = PriceModel::findOrFail($id);
        $price->update($request->except(['document','document_type_id','document_ids']));

        $existingDocs = FlatDocuments::where('price_id',$price->id)->get()->keyBy('id');
        $submittedIds = $request->input('document_ids', []);

        $toDelete = $existingDocs->keys()->diff(array_filter($submittedIds));
        foreach($toDelete as $docId) {
            $doc = $existingDocs[$docId];
            if($doc->file_path && \Storage::disk('public')->exists($doc->file_path)) {
                \Storage::disk('public')->delete($doc->file_path);
            }
            $doc->delete();
        }

        if($request->has('document_type_id')){
            foreach($request->document_type_id as $i => $docTypeId){
                if(!$docTypeId) continue;
                $filePath = null;
                if($request->hasFile("document.$i")){
                    $file = $request->file("document.$i");
                    $fileName = time().'_'.$file->getClientOriginalName();
                    $filePath = $file->storeAs('uploads/flat_documents', $fileName,'public');
                }

                $docId = $submittedIds[$i] ?? null;

                if($docId && isset($existingDocs[$docId])){
                    $doc = $existingDocs[$docId];
                    $doc->document_type_id = $docTypeId;
                    if($filePath){
                        if($doc->file_path && \Storage::disk('public')->exists($doc->file_path)){
                            \Storage::disk('public')->delete($doc->file_path);
                        }
                        $doc->file_path = $filePath;
                    }
                    $doc->save();
                } else {
                    if($filePath){
                        FlatDocuments::create([
                            'price_id' => $price->id,
                            'document_type_id' => $docTypeId,
                            'file_path' => $filePath,
                        ]);
                    }
                }
            }
        }
        return redirect()->route('price')->with('success', 'Price and documents updated successfully!');
    }


    public function downloadDocument($id)
    {
        $doc = FlatDocuments::findOrFail($id);
        $filePath = public_path($doc->file_path);

        if (file_exists($filePath)) {
            return response()->download($filePath, basename($filePath));
        } else {
            return redirect()->back()->with('error', 'File not found!');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $price = PriceModel::find($id);

        if ($price) {
            $documents = FlatDocuments::where('price_id', $price->id)->get();
            foreach ($documents as $doc) {
                $filePath = public_path($doc->file_path);
                if (file_exists($filePath)) {
                    unlink($filePath); 
                }
                $doc->delete();
            }
            EmiPayment::where('price_id', $id)->delete();
            Invoices::where('price_id', $id)->delete();
            $price->delete();

            return redirect()->route('price')->with('success', 'Price and related documents deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Price not found.');
        }
    }
}
