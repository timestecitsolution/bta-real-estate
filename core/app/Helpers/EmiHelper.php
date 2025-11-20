<?php
use Carbon\Carbon;

function calculateNextEmiStatus($price, $monthly_emi, $emis)
{

    $dealStartDate = Carbon::parse($price->emi_start_date);
    $totalPaid = 0;
    foreach ($emis as $emi) {
        $totalPaid += floatval($emi->emi_amount);
    }

    $emiCovered = floor($totalPaid / $monthly_emi);
    $partialRemaining = $totalPaid % $monthly_emi;

    $nextEmiDueDate = $dealStartDate->copy()->addMonths($emiCovered);

    $currentDueAmount = $partialRemaining > 0
        ? $monthly_emi - $partialRemaining
        : $monthly_emi;

    return [
        'emi_covered'        => $emiCovered,
        'partial_remaining'  => $partialRemaining,
        'next_emi_due_date'  => $nextEmiDueDate,
        'current_due_amount' => $currentDueAmount,
    ];
}
