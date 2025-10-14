<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PriceModel;
use App\Models\EmiPayment;
use App\Models\Contact;
use App\Models\Invoices;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class EmiController extends Controller
{
    public function create()
    {
        $all = Session::all();
        return view('booking.form', compact('all'));
    }

    public function storeEmi(Request $request)
    {
        $request->validate([
            'price_id' => 'required|exists:price,id',
            'emi_paying_date' => 'required|date',
            'payment_method' => 'required|in:cash,check,bank_transfer',
        ]);

        if (in_array($request->payment_method, ['check', 'bank_transfer'])) {
        $request->validate([
            'transaction_no' => 'nullable|string|max:255',
            'check_ds_image' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        } else {
            $request->validate([
                'transaction_no' => 'nullable|string|max:255',
                'check_ds_image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            ]);
        }

        $lastEmi = EmiPayment::where('price_id', $request->price_id)
            ->orderBy('id', 'desc')
            ->first();
        if($request->extras_amount_check == 1){
            $request->validate([
                'extras_amount' => 'required|numeric|min:1',
            ]);
            $payment_category = 'extras';
            $extras_amount = $request->extras_amount;
            $emi_amount = null;
            $remaining_emi_count = $request->remaining_emi_count;
        }else{
            $request->validate([
                'current_installment_amount' => 'required|numeric|min:1',
            ]);
            $payment_category = 'emi';
            $extras_amount = null;
            $emi_amount = $request->current_installment_amount;
            $remaining_emi_count = $lastEmi ? $lastEmi->remaining_emi_count - 1 : $request->remaining_emi_count - 1;
        }
        $remaining_due = $lastEmi ? $lastEmi->remaining_due - $request->current_installment_amount : $request->due_amount - $request->current_installment_amount;
        $remaining_due_with_extras = $lastEmi ? $lastEmi->remaining_due_amount_with_extras - $request->current_installment_amount : $request->remaining_due_amount_with_extras - $request->current_installment_amount;
        $number_format_remaining_due = number_format((float)$remaining_due, 2, '.', '');
        $number_format_current_installment_amount = number_format((float)$request->current_installment_amount, 2, '.', '');
        $next_emi_date = Carbon::parse($request->emi_due_date)->addMonth()->format('Y-m-d');

        // Handle file upload
        $documentPath = null;
        if ($request->hasFile('check_ds_image')) {
            $folder = public_path('emi_payment_document');
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true); 
            }
            $file = $request->file('check_ds_image');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($folder, $fileName);
            $documentPath = 'emi_payment_document/' . $fileName;
        }

        $user = Auth::guard('user')->user();
        if($user->status == 1){
            $status = 'approved';
        }else{
            $status = 'pending';
        }
        $emi = EmiPayment::create([
            'price_id' => $request->price_id,
            'emi_amount' => $emi_amount,
            'extras_amount' => $extras_amount,
            'payment_category' => $payment_category,
            'emi_due_date' => $request->emi_due_date,
            'emi_paid_date' => $request->emi_paying_date,
            'status' => $status,
            'remaining_due' => $remaining_due,
            'remaining_due_amount_with_extras' => $remaining_due_with_extras,
            'total_paid_amount' => $request->total_paid_amount,
            'total_paid_amount_with_extras' => $request->total_paid_amount_with_extras,
            'remaining_emi_count' => $remaining_emi_count,
            'payment_method' => $request->payment_method,
            'trx_no' => $request->transaction_no,
            'document_path' => $documentPath,
            'voucher_no' => $request->voucher_no,
            'note' => $request->note,
            'created_by' => Auth::guard('user')->user()->id,
            'updated_by' => Auth::guard('user')->user()->id,
        ]);

        if ($emi) {
            // =====================
            // Generate Invoice No
            // =====================
            $lastInvoice = Invoices::orderBy('id', 'desc')->first();
            $nextInvoiceNo = $lastInvoice ? $lastInvoice->id + 1 : 1;
            $invoiceNo = 'INV-' . str_pad($nextInvoiceNo, 5, '0', STR_PAD_LEFT);
            if($emi_amount){
                $total_price_invoice = $emi_amount;
            }else{
                $total_price_invoice = $extras_amount;
            }
            // Insert into invoices table
            Invoices::create([
                'invoice_no'  => $invoiceNo,
                'payment_type'=> 'emi',
                'emi_id'    => $emi->id,
                'client_id'   => $request->customer_id_select,
                'total_price' => $total_price_invoice,
                'created_by'  => Auth::guard('user')->user()->id,
            ]);

            // Send SMS to customer
            $contacts = Contact::find($request->customer_id);
            $customerPhone = '88'.$contacts->phone; 
            $prices = PriceModel::find($request->price_id);
            $project = $prices->project;

            $message = "Dear {$contacts->first_name},\n"
                    . "Your flat EMI has been paid for the project: {$project->title_en}, Flat No: {$prices->flat->title}.\n"
                    . "EMI Amount: {$number_format_current_installment_amount} BDT,\n"
                    . "Paid Date: {$request->emi_paying_date},\n"
                    . "Your Remaining Due Amount: {$number_format_remaining_due} BDT,\n"
                    . "Remaining EMI Count: {$remaining_emi_count},\n"
                    . "Next EMI Date: {$next_emi_date}.\n"
                    . "Thank you for choosing us.\n"
                    . "- Building Technology & Architecture.";
            // SMSService::send($customerPhone, $message);
            return redirect()->back()->with('success', 'EMI saved successfully!');
        }else {
            return redirect()->back()->with('error', 'Failed to add price. Please try again.');
        }

    }

    public function getFlatDetails(Request $request)
    {
        $flatId = $request->flat_id;

        $price = PriceModel::with(['project', 'flat', 'customer'])->where('flat_id', $flatId)->first();
        if (!$price) {
            return response()->json(['error' => 'No data found'], 404);
        }

        $monthlyEmi = $price->emi;
        $totalEmiCount = $price->emi_count;
        $dueAmount = $price->due_amount;

        $emis = EmiPayment::where('price_id', $price->id)
                  ->where('status', 'approved')
                  ->get();

        $totalExtrasPaid = $emis->sum('extras_amount');
        $remainingExtras = $price->extras_amount - $totalExtrasPaid ?? 0;
        $latestRemainingDue = $emis->sortByDesc('id')->first()->remaining_due ?? $dueAmount;
        $latestStatus = $emis->sortByDesc('id')->first()->status ?? null;

        if ($emis->count() > 0) {
            $paidEmi = $emis->where('status', 'approved');
            // $remainingEmiCount = ceil($latestRemainingDue / $monthlyEmi);
            $remainingEmiCount = $emis->sortByDesc('id')->first()->remaining_emi_count ?? $totalEmiCount;

            $sumPaidEmi = $paidEmi->sum('emi_amount');

            $lastPaidEmi = $paidEmi->sortByDesc('emi_due_date')->first();
            if ($lastPaidEmi) {
                $nextEmiDueDate = Carbon::parse($lastPaidEmi->emi_due_date)->addMonth();
            } else {
                $nextEmiDueDate = Carbon::parse($price->emi_start_date);
            }

            $currentDueAmount = $monthlyEmi;

        } else {
            $remainingEmiCount = $totalEmiCount;
            $nextEmiDueDate = Carbon::parse($price->emi_start_date);
            $currentDueAmount = $monthlyEmi;
            $sumPaidEmi = 0;
        }

        $totalPaidAmount = ($price->booking_amount ?? 0) + ($price->downpayment_amount ?? 0) + $sumPaidEmi;
        $totalPaidAmount = ($price->booking_amount ?? 0) + ($price->downpayment_amount ?? 0) + $sumPaidEmi;
        $totalPaidAmountWithExtras = $totalPaidAmount + $totalExtrasPaid;
        $dueAmountWithExtras = $dueAmount + $remainingExtras;
        $remainingDueAmountWithExtras = $latestRemainingDue + $remainingExtras;

        return response()->json([
            'price_id' => $price->id,
            'project_id' => $price->project_id,
            'flat_id' => $price->flat_id,
            'flat_size' => $price->flat_size,
            'customer_id' => $price->customer_id,
            'price_per_sqft' => $price->price_per_sqft,
            'total_price' => $price->price,
            'emi' => $monthlyEmi,
            'booking_amount' => $price->booking_amount,
            'downpayment_amount' => $price->downpayment_amount,
            'due_amount' => $dueAmount,
            'remaining_due_amount' => $latestRemainingDue,
            'is_negotiable_total_price' => $price->is_negotiable_total_price,
            'extras_amount' => $remainingExtras,
            'emi_count' => $totalEmiCount,
            'remaining_emi_count' => $remainingEmiCount,
            'total_paid_amount' => $totalPaidAmount,
            'total_extras_paid' => $totalExtrasPaid,
            'latest_status' => $latestStatus,
            'total_paid_amount_with_extras' => $totalPaidAmountWithExtras,
            'due_amount_with_extras' => $dueAmountWithExtras,
            'remaining_due_amount_with_extras' => $remainingDueAmountWithExtras,
            'current_installment_amount' => $currentDueAmount,
            'emi_start_date' => $price->emi_start_date,
            'emi_due_date' => $nextEmiDueDate->format('Y-m-d'),
        ]);
    }

    public function getCustomerFlats(Request $request)
    {
        $customerId = $request->customer_id;

        $flats = PriceModel::with(['flat', 'project'])
            ->where('customer_id', $customerId)
            ->get()
            ->map(function($price) {
                return [
                    'flat_id' => $price->flat->id,
                    'flat_title' => $price->flat->title,
                    'project_title' => $price->project->title_en
                ];
            });

        return response()->json($flats);
    }

    public function approve($id)
    {
        $emi = EmiPayment::findOrFail($id);
        $emi->status = 'approved';
        $emi->save();

        return redirect()->back()->with('success', 'EMI approved successfully.');
    }

    public function reject($id)
    {
        $emi = EmiPayment::findOrFail($id);
        $emi->status = 'rejected';
        $emi->save();

        return redirect()->back()->with('success', 'EMI rejected successfully.');
    }

    public function destroy($id)
    {
        $emi = EmiPayment::findOrFail($id);
        Invoices::where('emi_id', $id)->delete();
        $emi->delete();

        return redirect()->back()->with('success', 'EMI deleted successfully.');
    }

    public function showDocument($id)
    {
        $emi = EmiPayment::findOrFail($id);

        if (!$emi->document_path || !file_exists(public_path($emi->document_path))) {
            abort(404, 'Document not found.');
        }

        return response()->file(public_path($emi->document_path));
    }

    public function downloadDocument($id)
    {
        $emi = EmiPayment::findOrFail($id);

        if (!$emi->document_path || !file_exists(public_path($emi->document_path))) {
            abort(404, 'Document not found.');
        }

        return response()->download(public_path($emi->document_path));
    }

}
