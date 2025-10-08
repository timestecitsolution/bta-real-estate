<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceModel extends Model
{
    use HasFactory;
    protected $table = 'price';
    protected $fillable = [
        'project_id',
        'flat_id',
        'flat_size',
        'customer_id',
        'is_negotiable_total_price',
        'price_per_sqft',
        'price',
        'due_amount',
        'emi',
        'booking_amount',
        'downpayment_amount',
        'emi_count',
        'emi_start_date',
        'is_applicable_govt_gas',
        'is_govt_gas_connection_paid',
        'govt_gas_connection_payment_scheme',
        'gas_amount',
        'is_applicable_parking',
        'is_parking_paid',
        'parking_payment_scheme',
        'parking_amount',
        'is_utility_included',
        'utility_payment_scheme',
        'utility_amount',
        'extras_amount',
        'is_discount_applicable',
        'discount_amount',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function project()
    {
        return $this->belongsTo(Topics::class, 'project_id');
    }

    public function flat()
    {
        return $this->belongsTo(Tags::class, 'flat_id');
    }

    public function customer()
    {
        return $this->belongsTo(Contact::class, 'customer_id');
    }

    public function emis()
    {
        return $this->hasMany(EmiPayment::class, 'price_id');
    }

    public function documents()
    {
        return $this->hasMany(FlatDocuments::class, 'price_id');
    }

    public function invoices()
    {
        return $this->hasOne(Invoices::class, 'price_id');
    }

}
