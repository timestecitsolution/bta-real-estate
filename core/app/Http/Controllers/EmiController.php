<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use App\Models\PriceModel;
use App\Models\EmiPayment;
use App\Models\Contact;
use App\Models\Invoices;
use App\Models\FlatBookingModel;
use App\Models\Transactions;
use App\Models\EmiPaymentItems;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\SMSService;

class EmiController extends Controller
{
    public function create()
    {
        $all = Session::all();
        return view('booking.form', compact('all'));
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
    // public function storeEmi(Request $request)
    // {
    //     $request->validate([
    //         'price_id' => 'required|exists:price,id',
    //         'emi_paying_date' => 'required|date',
    //         'payment_method' => 'required|in:cash,check,bank_transfer',
    //     ]);

    //     if (in_array($request->payment_method, ['check', 'bank_transfer'])) {
    //     $request->validate([
    //         'transaction_no' => 'nullable|string|max:255',
    //         'check_ds_image' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    //     ]);
    //     } else {
    //         $request->validate([
    //             'transaction_no' => 'nullable|string|max:255',
    //             'check_ds_image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
    //         ]);
    //     }

    //     $lastEmi = EmiPayment::where('price_id', $request->price_id)
    //         ->orderBy('id', 'desc')
    //         ->first();
    //     if($request->extras_amount_check == 1){
    //         $request->validate([
    //             'extras_amount' => 'required|numeric|min:1',
    //         ]);
    //         $payment_category = 'extras';
    //         $extras_amount = $request->extras_amount;
    //         $emi_amount = null;
    //     }else{
    //         $request->validate([
    //             'current_installment_amount' => 'required|numeric|min:1',
    //         ]);
    //         $payment_category = 'emi';
    //         $extras_amount = null;
    //         $emi_amount = $request->current_installment_amount;
    //     }
    //     $number_format_current_installment_amount = number_format((float)$request->current_installment_amount, 2, '.', '');
    //     $next_emi_date = Carbon::parse($request->emi_due_date)->addMonth()->format('Y-m-d');

    //     // Handle file upload
    //     $documentPath = null;
    //     if ($request->hasFile('check_ds_image')) {
    //         $path = $this->getUploadPath('emi_payment_document');
    //         $file = $request->file('check_ds_image');
    //         $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    //         $file->move($path, $fileName);
    //         Helper::imageResize($path . $fileName);
    //         Helper::imageOptimize($path . $fileName);
    //         $documentPath = 'emi_payment_document/' . $fileName;
    //     }

    //     $user = Auth::guard('user')->user();
    //     if($user->status == 1){
    //         $status = 'approved';
    //     }else{
    //         $status = 'pending';
    //     }
    //     $emi = EmiPayment::create([
    //         'price_id' => $request->price_id,
    //         'emi_amount' => $emi_amount,
    //         'extras_amount' => $extras_amount,
    //         'payment_category' => $payment_category,
    //         'emi_due_date' => $request->emi_due_date,
    //         'emi_paid_date' => $request->emi_paying_date,
    //         'status' => $status,
    //         'payment_method' => $request->payment_method,
    //         'trx_no' => $request->transaction_no,
    //         'document_path' => $documentPath,
    //         'voucher_no' => $request->voucher_no,
    //         'note' => $request->note,
    //         'created_by' => Auth::guard('user')->user()->id,
    //         'updated_by' => Auth::guard('user')->user()->id,
    //     ]);

    //     if ($emi) {
    //         // =====================
    //         // Generate Invoice No
    //         // =====================
    //         $lastInvoice = Invoices::orderBy('id', 'desc')->first();
    //         $nextInvoiceNo = $lastInvoice ? $lastInvoice->id + 1 : 1;
    //         $invoiceNo = 'INV-' . str_pad($nextInvoiceNo, 5, '0', STR_PAD_LEFT);
    //         if($emi_amount){
    //             $total_price_invoice = $emi_amount;
    //         }else{
    //             $total_price_invoice = $extras_amount;
    //         }
    //         // Insert into invoices table
    //         Invoices::create([
    //             'invoice_no'  => $invoiceNo,
    //             'payment_type'=> 'emi',
    //             'emi_id'    => $emi->id,
    //             'client_id'   => $request->customer_id_select,
    //             'total_price' => $total_price_invoice,
    //             'created_by'  => Auth::guard('user')->user()->id,
    //         ]);

    //         // Send SMS to customer
    //         $contacts = Contact::find($request->customer_id);
    //         $customerPhone = '88'.$contacts->phone; 
    //         $prices = PriceModel::find($request->price_id);
    //         $project = $prices->project;

    //         $message = "Dear {$contacts->first_name},\n"
    //                 . "Your flat EMI has been paid for the project: {$project->title_en}, Flat No: {$prices->flat->title}.\n"
    //                 . "EMI Amount: {$number_format_current_installment_amount} BDT,\n"
    //                 . "Paid Date: {$request->emi_paying_date},\n"
    //                 // . "Your Remaining Due Amount: {$number_format_remaining_due} BDT,\n"
    //                 // . "Remaining EMI Count: {$remaining_emi_count},\n"
    //                 . "Next EMI Date: {$next_emi_date}.\n"
    //                 . "Thank you for choosing us.\n"
    //                 . "- Building Technology & Architecture.";
    //         SMSService::send($customerPhone, $message);
    //         return redirect()->back()->with('success', 'EMI saved successfully!');
    //     }else {
    //         return redirect()->back()->with('error', 'Failed to add price. Please try again.');
    //     }
    // }

    public function storeEmi(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:flat_booking,id',
            'client_id_select' => 'required|exists:contacts,id',
            'flat_id' => 'required|array',
            'flat_id.*' => 'required|integer',
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

        $lastEmi = EmiPayment::where('booking_id', $request->booking_id)
            ->orderBy('id', 'desc')
            ->first();

        if ($request->extras_amount_check == 1) {
            $request->validate([
                'extras_amount' => 'required|numeric|min:1',
            ]);
            $emi_amount = null;
            $extras_amount = $request->extras_amount;
            $amount = $request->extras_amount;
            $transactionType = 'EXTRA';
            $chargeType = 'EXTRA';
        } else {
            $request->validate([
                'current_installment_amount' => 'required|numeric|min:1',
            ]);
            $emi_amount = $request->current_installment_amount;
            $extras_amount = null;
            $amount = $request->current_installment_amount;
            $transactionType = 'EMI';
            $chargeType = 'EMI';
        }

        $number_format_current_installment_amount = number_format((float)$request->current_installment_amount, 2, '.', '');
        $next_emi_date = Carbon::parse($request->emi_due_date)->addMonth()->format('Y-m-d');

        // Handle file upload
        $documentPath = null;
        if ($request->hasFile('check_ds_image')) {
            $path = $this->getUploadPath('emi_payment_document');
            $file = $request->file('check_ds_image');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $fileName);
            Helper::imageResize($path . $fileName);
            Helper::imageOptimize($path . $fileName);
            $documentPath = 'emi_payment_document/' . $fileName;
        }

        DB::beginTransaction();

        try {

            $user = Auth::guard('user')->user();
            $status = $user->status == 1 ? 'Paid' : 'Pending';

            // =======================
            // 1️⃣ TRANSACTION
            // =======================
            $transaction = Transactions::create([
                'booking_id' => $request->booking_id,
                'transaction_type' => $transactionType,
                'amount' => $amount,
                'payment_method' => $request->payment_method,
                'trx_no' => $request->transaction_no,
                'voucher_no' => $request->voucher_no,
                'document_path' => $documentPath,
                'note' => $request->note,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $transactionId = $transaction->id;
            // =======================
            // 2️⃣ EMI PAYMENT
            // =======================
            $emiPayment = EmiPayment::create([
                'transaction_id' => $transactionId,
                'booking_id' => $request->booking_id,
                'total_amount' => $emi_amount,
                'total_extras' => $extras_amount,
                'emi_due_date' => $request->emi_due_date,
                'emi_paid_date' => $request->emi_paying_date,
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $emiPaymentId = $emiPayment->id;

            // =======================
            // 3️⃣ EMI PAYMENT ITEMS (FLAT WISE SPLIT)
            // =======================
            $flatIds = $request->flat_id;

            if (empty($flatIds)) {
                throw new \Exception('No flats selected');
            }

            $perFlatAmount = $amount / count($flatIds);

            foreach ($flatIds as $flatId) {

                $flatInfo = DB::table('booked_flat_info')
                    ->where('booking_id', $request->booking_id)
                    ->where('flat_id', $flatId)
                    ->first();

                if (!$flatInfo) {
                    continue; 
                }

                $data = [
                    'emi_payment_id' => $emiPaymentId,
                    'flat_info_id'   => $flatInfo->id,
                    'charge_type'    => $chargeType,
                    'status'         => $status,
                    'emi_due_date'   => $request->emi_due_date,
                    'emi_paid_date'  => $request->emi_paying_date,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];

                if ($request->extras_amount_check == 1) {
                    $data['extras_amount'] = $perFlatAmount;
                    $data['amount'] = null;
                } else {
                    $data['extras_amount'] = null;
                    $data['amount'] = $perFlatAmount;
                }

                EmiPaymentItems::create($data);
            }

            // =======================
            // 4️⃣ INVOICE (OLD STRUCTURE KEEP)
            // =======================
            $lastInvoice = Invoices::orderBy('id', 'desc')->first();
            if ($lastInvoice) {
                $lastNumber = (int) str_replace('INV-', '', $lastInvoice->invoice_no);
                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }

            // Generate new invoice number
            $invoiceNo = 'INV-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            Invoices::create([
                'transaction_id' => $transactionId,
                'invoice_no'  => $invoiceNo,
                'payment_type'=> strtolower($transactionType),
                'emi_payment_id' => $emiPaymentId,
                'client_id'   => $request->client_id_select,
                'total_price' => $amount,
                'created_by'  => $user->id,
            ]);

            DB::commit();

            // =======================
            // SMS
            // =======================
            $contact = Contact::find($request->client_id_select);

            $flats = FlatBookingModel::with(['flatBookingDetails.projects', 'flatBookingDetails.flats'])
                ->where('id', $request->booking_id)
                ->get()
                ->flatMap(function($booking) {
                    return $booking->flatBookingDetails->map(function($detail) {
                        return [
                            'flat_title' => optional($detail->flats)->flat_name,
                            'project_title' => optional($detail->projects)->title_en
                        ];
                    });
                });

            // collect flat names
            $flatNames = $flats->pluck('flat_title')->filter()->unique()->values()->toArray();

            // collect project names
            $projectNames = $flats->pluck('project_title')->filter()->unique()->values()->toArray();

            // format flat string
            $flatText = implode(', ', $flatNames);

            // format project string
            $projectText = implode(', ', $projectNames);

            // next emi date
            $next_emi_date = Carbon::parse($request->emi_due_date)->addMonth()->format('Y-m-d');

            // final message
            $message = "Dear {$contact->first_name},\n"
                . "Your payment received for Flat: {$flatText} ({$projectText})\n"
                . "Amount: {$amount} BDT\n"
                . "Date: {$request->emi_paying_date}\n"
                . "Next EMI Date: {$next_emi_date}\n"
                . "Thank you.";

            SMSService::send('88' . $contact->phone, $message);

            return back()->with('success', 'Payment saved successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
    // public function getFlatDetails(Request $request)
    // {
    //     $flatId = $request->flat_id;

    //     $price = PriceModel::with(['project', 'flat', 'customer'])
    //         ->where('flat_id', $flatId)
    //         ->first();

    //     if (!$price) {
    //         return response()->json(['error' => 'No data found'], 404);
    //     }

    //     // Base variables
    //     $total_price = floatval($price->price ?? 0);
    //     $emi_count = intval($price->emi_count ?? 0);
    //     $monthly_emi = floatval($price->emi ?? 0);
    //     $due_amount = floatval($price->due_amount ?? 0);
    //     $extras_amount_total = floatval($price->extras_amount ?? 0);

    //     // Fetch EMI Payments
    //     $emis = EmiPayment::where('price_id', $price->id)
    //         ->where('status', 'approved')
    //         ->orderBy('id', 'asc')
    //         ->get();

    //     // Default initialization
    //     $total_paid = 0;
    //     $total_paid_with_extras = 0;
    //     $actual_emi_paid_count = 0;

    //     // Dynamic calculation (same as dashboard)
    //     foreach ($emis as $emi) {
    //         $emi_amount = floatval($emi->emi_amount ?? 0);
    //         $extras_amount = floatval($emi->extras_amount ?? 0);

    //         if ($emi_amount > 0) {
    //             $total_paid += $emi_amount;
    //             $actual_emi_paid_count++;
    //         }

    //         $total_paid_with_extras += ($emi_amount + $extras_amount);
    //     }

    //     // Derived values (dynamic)
    //     $remaining_due = max($total_price - $total_paid, 0);
    //     $remaining_due_amount_with_extras = max($total_price - $total_paid_with_extras, 0);
    //     $remaining_emi_count = max($emi_count - $actual_emi_paid_count, 0);

    //     // Extras calculation
    //     $total_extras_paid = $emis->sum('extras_amount');
    //     $remaining_extras = max($extras_amount_total - $total_extras_paid, 0);

    //     // Next EMI date calculation
    //     $lastEmi = $emis->sortByDesc('emi_due_date')->first();
    //     if ($lastEmi) {
    //         $nextEmiDueDate = \Carbon\Carbon::parse($lastEmi->emi_due_date)->addMonth();
    //     } else {
    //         $nextEmiDueDate = \Carbon\Carbon::parse($price->emi_start_date);
    //     }
    //     $latestStatus = EmiPayment::where('price_id', $price->id)
    //                     ->orderByDesc('id')
    //                     ->first()
    //                     ->status ?? null;

    //     $currentDueAmount = $monthly_emi;

    //     // Grand totals
    //     $totalPaidAmount = ($price->booking_amount ?? 0) + ($price->downpayment_amount ?? 0) + $total_paid;
    //     $totalPaidAmountWithExtras = $totalPaidAmount + $total_extras_paid;
    //     $dueAmountWithExtras = $due_amount + $remaining_extras;

    //     return response()->json([
    //         'price_id' => $price->id,
    //         'project_id' => $price->project_id,
    //         'flat_id' => $price->flat_id,
    //         'flat_size' => $price->flat_size,
    //         'customer_id' => $price->customer_id,
    //         'price_per_sqft' => $price->price_per_sqft,
    //         'total_price' => $price->price,
    //         'emi' => $monthly_emi,
    //         'booking_amount' => $price->booking_amount,
    //         'downpayment_amount' => $price->downpayment_amount,
    //         'due_amount' => $due_amount,
    //         'remaining_due_amount' => $remaining_due,
    //         'extras_amount' => $remaining_extras,
    //         'emi_count' => $emi_count,
    //         'remaining_emi_count' => $remaining_emi_count,
    //         'total_paid_amount' => $total_paid,
    //         'total_extras_paid' => $total_extras_paid,
    //         'latest_status' => $latestStatus,
    //         'total_paid_amount_with_extras' => $total_paid_with_extras,
    //         'remaining_due_amount_with_extras' => $remaining_due_amount_with_extras,
    //         'total_paid_amount_final' => $totalPaidAmount,
    //         'total_paid_amount_with_extras_final' => $totalPaidAmountWithExtras,
    //         'due_amount_with_extras' => $dueAmountWithExtras,
    //         'current_installment_amount' => $currentDueAmount,
    //         'emi_start_date' => $price->emi_start_date,
    //         'emi_due_date' => $nextEmiDueDate->format('Y-m-d'),
    //         'is_cancelled' => $price->is_cancelled,
    //     ]);
    // }


    public function getFlatDetails(Request $request)
    {
        $flatId = $request->flat_id;

        $flat_booking = FlatBookingModel::with(['client', 'flatBookingDetails.projects', 'flatBookingDetails.flats'])
        ->whereHas('flatBookingDetails', function($query) use ($flatId) {
            $query->where('flat_id', $flatId);
        })->first();

        $flat_booking_detail = $flat_booking->flatBookingDetails->first();

        if (!$flat_booking) {
            return response()->json(['error' => 'No data found'], 404);
        }

        // Base variables
        $total_price = floatval($flat_booking->total_price ?? 0);
        $emi_count = intval($flat_booking->emi_count ?? 0);
        $monthly_emi = floatval($flat_booking->total_emi_amount ?? 0);
        $due_amount = floatval($flat_booking->due_amount_total ?? 0);
        $extras_amount_total = floatval($flat_booking->extras_total ?? 0);

        // Fetch EMI Payments
        $emis = EmiPayment::where('booking_id', $flat_booking->id)
            ->where('status', 'Paid')
            ->orderBy('id', 'asc')
            ->get();

        // Default initialization
        $total_paid = 0;
        $total_paid_with_extras = 0;
        $actual_emi_paid_count = 0;

        // Dynamic calculation (same as dashboard)
        foreach ($emis as $emi) {
            $emi_amount = floatval($emi->total_amount ?? 0);
            $extras_amount = floatval($emi->total_extras ?? 0);

            if ($emi_amount > 0) {
                $total_paid += $emi_amount;
                $actual_emi_paid_count++;
            }

            $total_paid_with_extras += ($emi_amount + $extras_amount);
        }

        // Derived values (dynamic)
        $remaining_due = max($total_price - $total_paid, 0);
        $remaining_due_amount_with_extras = max($total_price - $total_paid_with_extras, 0);
        $remaining_emi_count = max($emi_count - $actual_emi_paid_count, 0);

        // Extras calculation
        $total_extras_paid = $emis->sum('total_extras');
        $remaining_extras = max($extras_amount_total - $total_extras_paid, 0);

        // Next EMI date calculation
        $lastEmi = $emis->sortByDesc('emi_due_date')->first();
        if ($lastEmi) {
            $nextEmiDueDate = \Carbon\Carbon::parse($lastEmi->emi_due_date)->addMonth();
        } else {
            $nextEmiDueDate = \Carbon\Carbon::parse($flat_booking->emi_start_date);
        }
        $latestStatus = EmiPayment::where('booking_id', $flat_booking->id)
                        ->orderByDesc('id')
                        ->first()
                        ->status ?? null;

        $currentDueAmount = $monthly_emi;

        // Grand totals
        $totalPaidAmount = ($flat_booking->booking_amount ?? 0) + ($flat_booking->downpayment_amount ?? 0) + $total_paid;
        $totalPaidAmountWithExtras = $totalPaidAmount + $total_extras_paid;
        $dueAmountWithExtras = $due_amount + $remaining_extras;

        return response()->json([
            'booking_id' => $flat_booking->id,
            'project_id' => $flat_booking_detail->project_id,
            'flat_id' => $flat_booking_detail->flat_id,
            'flat_size' => $flat_booking_detail->flat_size,
            'client_id' => $flat_booking->client_id,
            'price_per_sqft' => $flat_booking_detail->price_per_sqft,
            'total_price' => $flat_booking->total_price,
            'emi' => $monthly_emi,
            'booking_amount' => $flat_booking->booking_amount,
            'downpayment_amount' => $flat_booking->downpayment_amount,
            'due_amount' => $due_amount,
            'remaining_due_amount' => $remaining_due,
            'extras_amount' => $remaining_extras,
            'emi_count' => $emi_count,
            'remaining_emi_count' => $remaining_emi_count,
            'total_paid_amount' => $total_paid,
            'total_extras_paid' => $total_extras_paid,
            'latest_status' => $latestStatus,
            'total_paid_amount_with_extras' => $total_paid_with_extras,
            'remaining_due_amount_with_extras' => $remaining_due_amount_with_extras,
            'total_paid_amount_final' => $totalPaidAmount,
            'total_paid_amount_with_extras_final' => $totalPaidAmountWithExtras,
            'due_amount_with_extras' => $dueAmountWithExtras,
            'current_installment_amount' => $currentDueAmount,
            'emi_start_date' => $flat_booking->emi_start_date,
            'emi_due_date' => $nextEmiDueDate->format('Y-m-d'),
            'is_cancelled' => $flat_booking->is_cancelled,
        ]);
    }

    public function getClientFlats(Request $request)
    {
        $clientId = $request->client_id;

        $flats = FlatBookingModel::with(['client', 'flatBookingDetails.projects', 'flatBookingDetails.flats'])
            ->where('client_id', $clientId)
            ->get()
            ->flatMap(function($booking) {
                return $booking->flatBookingDetails->map(function($detail) {
                    return [
                        'flat_id' => optional($detail->flats)->id,
                        'flat_title' => optional($detail->flats)->flat_name,
                        'project_title' => optional($detail->projects)->title_en
                    ];
                });
            });
        return response()->json($flats);
    }

    public function approve($id)
    {
        DB::transaction(function () use ($id) {

            $emi = EmiPayment::findOrFail($id);

            // EMI Payment update
            $emi->update([
                'status' => 'Paid'
            ]);

            // EMI Payment Items update
            EmiPaymentItems::where('emi_payment_id', $emi->id)
                ->update(['status' => 'Paid']);

            // Transaction update (optional but better)
            Transactions::where('id', $emi->transaction_id)
                ->update(['status' => 'Completed' , 'updated_at' => now()]);

            // Invoice update (optional)
            Invoices::where('emi_payment_id', $emi->id)
                ->update(['updated_at' => now()]);
        });

        return back()->with('success', 'EMI approved successfully.');
    }

    public function reject($id)
    {
        DB::transaction(function () use ($id) {

            $emi = EmiPayment::findOrFail($id);

            // EMI Payment update
            $emi->update([
                'status' => 'Unpaid'
            ]);

            // EMI Payment Items update
            EmiPaymentItems::where('emi_payment_id', $emi->id)
                ->update(['status' => 'Unpaid']);

            // Transaction update (optional)
            Transactions::where('id', $emi->transaction_id)
                ->update(['status' => 'Cancelled', 'updated_at' => now()]);

            // Invoice update (optional)
            Invoices::where('emi_payment_id', $emi->id)
                ->update(['updated_at' => now()]);
        });

        return back()->with('success', 'EMI rejected successfully.');
    }

    public function editEmi(EmiPayment $emi)
    {
        return response()->json($emi);
    }

    public function updateEmi(Request $request, $id)
    {
        $rules = [
            'paying_date' => 'required|date',
            'payment_method_edit' => 'required|in:cash,check,bank_transfer',
            'voucher_no' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ];

        if ($request->has('emi_amount')) {
            $rules['emi_amount'] = 'required|numeric|min:0';

            $amount = $request->emi_amount;
            $emi_amount = $amount;
            $extras_amount = null;
            $transactionType = 'EMI';
            $chargeType = 'EMI';
        } elseif ($request->has('extras_amount')) {
            $rules['extras_amount'] = 'required|numeric|min:0';

            $amount = $request->extras_amount;
            $emi_amount = null;
            $extras_amount = $amount;
            $transactionType = 'EXTRA';
            $chargeType = 'EXTRA';
        }
        $request->validate($rules);
        DB::beginTransaction();

        try {
            $emi = EmiPayment::findOrFail($id);
            $user = Auth::guard('user')->user();
            $status = $user->status == 1 ? 'Paid' : 'Pending';

            // =======================
            // Get Transaction
            // =======================
            $transaction = Transactions::findOrFail($emi->transaction_id);

            // =======================
            // File Upload (Replace)
            // =======================
            $documentPath = $transaction->document_path;

            if ($request->hasFile('check_ds_image_edit')) {

                // delete old file
                if ($documentPath) {
                    $oldPath = base_path('../uploads/' . $documentPath);
                    if (file_exists($oldPath)) {
                        @unlink($oldPath);
                    }
                }

                $file = $request->file('check_ds_image_edit');
                $path = $this->getUploadPath('emi_payment_document');

                $fileName = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
                $file->move($path, $fileName);

                $documentPath = 'emi_payment_document/' . $fileName;
            }

            // =======================
            // 1️⃣ Update TRANSACTION
            // =======================
            $transaction->update([
                'transaction_type' => $transactionType,
                'amount' => $amount,
                'payment_method' => $request->payment_method_edit,
                'trx_no' => $request->transaction_no_edit,
                'voucher_no' => $request->voucher_no,
                'document_path' => $documentPath,
                'note' => $request->note,
                'updated_by' => $user->id,
            ]);
            // =======================
            // 2️⃣ Update EMI PAYMENT
            // =======================
            $emi->update([
                'total_amount' => $emi_amount,
                'total_extras' => $extras_amount,
                'emi_due_date' => $request->emi_due_date,
                'emi_paid_date' => $request->paying_date,
                'status' => $status,
            ]);

            // =======================
            // 3️⃣ Delete Old Items
            // =======================
            EmiPaymentItems::where('emi_payment_id', $emi->id)->delete();

            // =======================
            // 4️⃣ Insert New Items
            // =======================
            $flatInfos = DB::table('booked_flat_info')
                ->where('booking_id', $request->booking_id)
                ->get()
                ->keyBy('flat_id');

            if ($flatInfos->isEmpty()) {
                throw new \Exception('No matching booked flats found');
            }

            $flatCount = count($flatInfos);
            $perFlatAmount = round($amount / $flatCount, 2);
            // dd($perFlatAmount);
            foreach ($flatInfos as $flatInfoId => $flatInfo) {


                $data = [
                    'emi_payment_id' => $emi->id,
                    'flat_info_id'   => $flatInfo->id,
                    'charge_type'    => $chargeType,
                    'status'         => $status,
                    'emi_paid_date'  => $request->paying_date,
                ];

                if ($chargeType === 'EXTRA') {
                    $data['extras_amount'] = $perFlatAmount;
                    $data['amount'] = null;
                } else {
                    $data['amount'] = $perFlatAmount;
                    $data['extras_amount'] = null;
                }
                EmiPaymentItems::create($data);
            }
            // =======================
            // 5️⃣ Update INVOICE
            // =======================
            Invoices::where('emi_payment_id', $emi->id)->update([
                'transaction_id' => $transaction->id,
                'total_price' => $amount,
                'payment_type' => strtolower($transactionType),
            ]);
            DB::commit();

            return response()->json([
                    'success' => true,
                    'message' => 'Payment updated successfully!'
                ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {

            // 1️⃣ Get EMI Payment
            $emi = EmiPayment::findOrFail($id);

            // 2️⃣ Get Transaction
            $transaction = DB::table('transactions')
                ->where('id', $emi->transaction_id)
                ->first();

            // 3️⃣ Delete file (if exists)
            if ($transaction && $transaction->document_path) {

                $filePath = base_path('../uploads/' . $transaction->document_path);

                if (file_exists($filePath)) {
                    if (!@unlink($filePath)) {
                        throw new \Exception("Could not delete file: {$filePath}");
                    }
                }
            }

            // 4️⃣ Delete invoices (based on emi_payment_id)
            DB::table('invoices')
                ->where('emi_payment_id', $emi->id)
                ->delete();

            // 5️⃣ Delete emi_payment_items (optional if FK cascade exists)
            DB::table('emi_payment_items')
                ->where('emi_payment_id', $emi->id)
                ->delete();

            // 6️⃣ Delete emi_payment
            $emi->delete();

            // 7️⃣ Delete transaction (important)
            if ($transaction) {
                DB::table('transactions')
                    ->where('id', $transaction->id)
                    ->delete();
            }

        });

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
