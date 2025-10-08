<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmiPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'price_id',
        'extras_amount',
        'payment_category',
        'emi_amount',
        'emi_due_date',
        'emi_paid_date',
        'status',
        'remaining_due',
        'remaining_due_amount_with_extras',
        'total_paid_amount',
        'total_paid_amount_with_extras',
        'remaining_emi_count',
        'payment_method',
        'trx_no',
        'document_path',
        'created_by',
        'updated_by',
    ];

    public function invoices()
    {
        return $this->hasOne(Invoices::class, 'emi_id');
    }
}
