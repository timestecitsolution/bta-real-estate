<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmiPaymentItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'emi_payment_id',
        'flat_info_id',
        'charge_type',
        'amount',
        'extras_amount',
        'status',
        'emi_due_date',
        'emi_paid_date',
    ];
}
