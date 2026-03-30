<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'transaction_type',
        'amount',
        'payment_method',
        'trx_no',
        'voucher_no',
        'document_path',
        'note',
        'created_by',
        'updated_by',
    ];
}
