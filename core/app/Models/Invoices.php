<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    use HasFactory;
    
    protected $table = 'invoices';

    protected $fillable = [
        'invoice_no',
        'payment_type',
        'emi_id',
        'price_id',
        'client_id',
        'total_price',
        'created_by',
    ];
}
