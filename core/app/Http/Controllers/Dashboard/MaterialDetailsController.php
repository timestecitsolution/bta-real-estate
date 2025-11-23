<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaterialDetails;
use App\Models\PriceModel;
use App\Models\Contact;
use App\Services\SMSService;

class MaterialDetailsController extends Controller
{
    public function MaterialChangeApplication(Request $request, $id)
    {
        $request->validate([
            'change_details' => 'required|string|max:5000',
        ]);

        $material = MaterialDetails::findOrFail($id);
        $price = PriceModel::findOrFail($material->price_id);
        $contact = Contact::findOrFail($price->customer_id);

        $material->change_details = $request->change_details;
        $material->status = 'pending'; 
        $material->save();
        $message = "Dear {$contact->first_name} {$contact->last_name},\n"
                    . "Your material change request for the flat ({$price->flat->title}) in project ({$price->project->title_en}) has been submitted successfully and is pending approval.\n"
                    . "We will notify you once the request has been reviewed.\n"
                    . "Thank you for choosing Building Technology & Architecture.";
        SMSService::send($contact->phone, $message);
        return back()->with('success', 'Material change request submitted successfully!');
    }
    public function MaterialChangeApproval(Request $request, $id)
    {
        $request->validate([
            'admin_status' => 'required|in:approved,rejected',
            'admin_note' => 'nullable|string|max:20000',
        ]);

        $material = MaterialDetails::findOrFail($id);
        $price = PriceModel::findOrFail($material->price_id);
        $contact = Contact::findOrFail($price->customer_id);

        $material->status = $request->admin_status;
        $material->admin_note = $request->admin_note;
        $material->save();

        $message = "Dear {$contact->first_name} {$contact->last_name},\n"
                    . "Your material change request for the flat ({$price->flat->title}) in project ({$price->project->title_en}) has been {$request->admin_status}.\n"
                    . "Admin Note: {$request->admin_note}\n"
                    . "Thank you for choosing Building Technology & Architecture.";

        SMSService::send($contact->phone, $message);

        return back()->with('success', 'Material change request has been ' . $request->admin_status . '.');
    }
}
