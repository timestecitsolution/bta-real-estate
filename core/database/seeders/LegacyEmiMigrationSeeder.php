<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LegacyEmiMigrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $legacyPayments = DB::table('legacy_emi_payments')->get();
        $mapStatus = [
            'approved' => 'Paid',
            'pending'  => 'Unpaid',
            'partial'  => 'Partial',
            null       => 'Unpaid',
        ];

        foreach ($legacyPayments as $payment) {

            DB::beginTransaction();

            try {

                /*
                --------------------------
                EMI AMOUNT
                --------------------------
                */

                if (!empty($payment->emi_amount) && $payment->emi_amount > 0) {

                    $transactionId = DB::table('transactions')->insertGetId([
                        'booking_id' => $payment->price_id,
                        'transaction_type' => 'EMI',
                        'amount' => $payment->emi_amount,
                        'payment_method' => $payment->payment_method,
                        'trx_no' => $payment->trx_no,
                        'voucher_no' => $payment->voucher_no,
                        'document_path' => $payment->document_path,
                        'note' => $payment->note,
                        'created_by' => $payment->created_by,
                        'updated_by' => $payment->updated_by,
                        'created_at' => $payment->created_at,
                        'updated_at' => $payment->updated_at,
                    ]);

                    $emiPaymentId = DB::table('emi_payments')->insertGetId([
                        'transaction_id' => $transactionId,
                        'booking_id' => $payment->price_id,
                        'total_amount' => $payment->emi_amount,
                        'emi_due_date' => $payment->emi_due_date,
                        'emi_paid_date' => $payment->emi_paid_date,
                        'status' => $mapStatus[strtolower($payment->status)] ?? 'Unpaid',
                        'created_at' => $payment->created_at,
                        'updated_at' => $payment->updated_at,
                    ]);

                    DB::table('emi_payment_items')->insert([
                        'emi_payment_id' => $emiPaymentId,
                        'flat_id' => '0',
                        'charge_type' => 'EMI',
                        'amount' => $payment->emi_amount,
                        'status' => $mapStatus[strtolower($payment->status)] ?? 'Unpaid',
                        'emi_due_date' => $payment->emi_due_date,
                        'emi_paid_date' => $payment->emi_paid_date,
                        'created_at' => $payment->created_at,
                        'updated_at' => $payment->updated_at,
                    ]);
                }

                /*
                --------------------------
                EXTRAS AMOUNT
                --------------------------
                */

                if (!empty($payment->extras_amount) && $payment->extras_amount > 0) {

                    $transactionId = DB::table('transactions')->insertGetId([
                        'booking_id' => $payment->price_id,
                        'transaction_type' => 'EXTRA',
                        'amount' => $payment->extras_amount,
                        'payment_method' => $payment->payment_method,
                        'trx_no' => $payment->trx_no,
                        'voucher_no' => $payment->voucher_no,
                        'document_path' => $payment->document_path,
                        'note' => $payment->note,
                        'created_by' => $payment->created_by,
                        'updated_by' => $payment->updated_by,
                        'created_at' => $payment->created_at,
                        'updated_at' => $payment->updated_at,
                    ]);

                    $emiPaymentId = DB::table('emi_payments')->insertGetId([
                        'transaction_id' => $transactionId,
                        'booking_id' => $payment->price_id,
                        'total_amount' => $payment->extras_amount,
                        'emi_due_date' => $payment->emi_due_date,
                        'emi_paid_date' => $payment->emi_paid_date,
                        'status' => $mapStatus[strtolower($payment->status)] ?? 'Unpaid',
                        'created_at' => $payment->created_at,
                        'updated_at' => $payment->updated_at,
                    ]);

                    DB::table('emi_payment_items')->insert([
                        'emi_payment_id' => $emiPaymentId,
                        'flat_id' => '0',
                        'charge_type' => 'EXTRA',
                        'amount' => $payment->extras_amount,
                        'status' => $mapStatus[strtolower($payment->status)] ?? 'Unpaid',
                        'emi_due_date' => $payment->emi_due_date,
                        'emi_paid_date' => $payment->emi_paid_date,
                        'created_at' => $payment->created_at,
                        'updated_at' => $payment->updated_at,
                    ]);
                }

                DB::commit();

            } catch (\Exception $e) {

                DB::rollBack();
                throw $e;
            }
        }
    }
}
