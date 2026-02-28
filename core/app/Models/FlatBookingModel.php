<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlatBookingModel extends Model
{
    use HasFactory;
    protected $table = 'flat_booking';
    protected $fillable = [
        'client_id',
        'is_discount_applicable_total',
        'discount_amount_total',
        'total_price',
        'booking_amount',
        'downpayment_amount',
        'extras_total',
        'due_amount_total',
        'total_emi_amount',
        'emi_count',
        'is_emi_date_combined',
        'emi_start_date',
    ];
    public function client()
    {
        return $this->belongsTo(Contact::class, 'client_id');
    }
    public function flatBookingDetails()
    {
        return $this->hasMany(BookedFlatInfo::class, 'booking_id', 'id');
    }
}
