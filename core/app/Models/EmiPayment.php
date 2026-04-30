<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmiPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'booking_id',
        'total_amount',
        'total_extras',
        'emi_due_date',
        'emi_paid_date',
        'status',
    ];

    public function invoices()
    {
        return $this->hasOne(Invoices::class, 'emi_payment_id', 'id');
    }

    public function emiPaymentItems()
    {
        return $this->hasMany(EmiPaymentItems::class, 'emi_payment_id','id');
    }

    public function transactions()
    {
        return $this->hasOne(Transactions::class, 'id' , 'transaction_id');
    }  
    public function booking()
    {
        return $this->belongsTo(FlatBookingModel::class, 'booking_id');
    }
}
