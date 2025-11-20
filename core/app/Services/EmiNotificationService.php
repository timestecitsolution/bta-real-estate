<?php

namespace App\Services;

use App\Models\PriceModel;
use App\Services\SMSService;
use Carbon\Carbon;

class EmiNotificationService
{
    public function run()
    {
        $prices = PriceModel::with([
            'customer',
            'emis' => function ($query) {
                $query->where('status', 'approved');
            }
        ])->get();

        foreach ($prices as $price) {

            $calc = calculateNextEmiStatus($price, $price->emi, $price->emis);

            $dueDate = $calc['next_emi_due_date'];
            $today = Carbon::today();

            $daysDiff = $today->diffInDays($dueDate, false);
            $monthsDiff = $today->diffInMonths($dueDate, false);
            $customerPhone = $price->customer->phone;
            // 3 days before due
            if ($daysDiff == 3) {
                SMSService::send($customerPhone, "Dear Customer, your EMI is due on {$dueDate->format('d M Y')} . Please make the payment on time to avoid any penalties. Thank you.");
            }

            // 3 days after missed
            if ($daysDiff == -3) {
                SMSService::send($customerPhone, "Dear Customer, you missed your EMI due on {$dueDate->format('d M Y')}. Please pay as soon as possible. Thank you.");
            }

            // 3 months unpaid
            if ($monthsDiff <= -3) {
                SMSService::send($customerPhone, "Dear Customer, you have missed your EMI payments for 3 months. As per our policy, your deal may be canceled with 5% demurrage. Please contact the authority immediately. Thank you.");
            }

            // cancellation schedule
            $cancelDate = $dueDate->copy()->addMonths(3);

            if ($today->equalTo($cancelDate->copy()->subWeek())) {
                SMSService::send($customerPhone, "Dear Customer, your deal is scheduled for cancellation in 7 days due to unpaid EMI for 3 months. Please contact us immediately to avoid demurrage.");
            }

            if ($today->equalTo($cancelDate->copy()->subDays(3))) {
                SMSService::send($customerPhone, "Dear Customer, your deal is scheduled for cancellation in 3 days due to unpaid EMI for 3 months. Please contact us immediately to avoid demurrage.");
            }

            if ($today->equalTo($cancelDate)) {
                SMSService::send($customerPhone, "Your deal is going to be canceled due to 3 months of unpaid EMI. As per policy, 5% of your total payment will be deducted as demurrage. Contact support for details.");
            }
        }
    }
}
