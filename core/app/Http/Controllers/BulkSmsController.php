<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\PriceModel;
use App\Models\BulkSmsData;
use App\Services\SMSService;

class BulkSmsController extends Controller
{
    public function bulksms(Request $request)
    {
        $request->validate([
            'customer_ids' => 'required|array|min:1',
            'message' => 'required|string|max:1000',
        ]);

        foreach ($request->customer_ids as $customer_id) {
            if ($customer_id === 'all') {
                continue; 
            }

            $contact = Contact::find($customer_id);

            if ($contact && $contact->phone) {
                $customerPhone = '88' . $contact->phone;

                $personalizedMessage = str_replace(
                    ['{name}'],
                    [$contact->first_name],
                    $request->message
                );

                $sms = BulkSmsData::create([
                    'phone_number' => $customerPhone,
                    'message' => $personalizedMessage,
                    'status' => 'pending'
                ]);

                SMSService::send($customerPhone, $personalizedMessage);

                $sms->update(['status' => 'sent']);
            }
        }

        return back()->with('success', 'SMS sent successfully!');
    }
}
