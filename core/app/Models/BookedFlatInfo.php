<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookedFlatInfo extends Model
{
    use HasFactory;
    protected $table = 'booked_flat_info';
    protected $fillable = [
        'booking_id',
        'project_id',
        'flat_id',
        'flat_size',
        'is_negotiate_total_price',
        'price_per_sqft',
        'is_govt_gas_included',
        'is_govt_gas_connection_paid',
        'govt_gas_payment_scheme',
        'gas_connection_fee',
        'is_parking_included',
        'is_parking_paid',
        'parking_payment_scheme',
        'parking_fee',
        'is_utility_included',
        'utility_payment_scheme',
        'utility_fee',
        'extras_amount',
        'is_applicable_discount',
        'discounted_amount',
        'total_price_flat',
        'emi_amount_flat',
        'emi_start_date_flat',
    ];
    public function projects(){
        return $this->belongsTo(Topic::class, 'project_id', 'id');
    }
    public function flats(){
        return $this->belongsTo(FlatDetailsModel::class, 'flat_id', 'id');
    }
    public function flatDocuments()
    {
        return $this->hasMany(FlatDocuments::class, 'booked_flat_id', 'id');
    }

    public function materialDocuments()
    {
        return $this->hasMany(MaterialDetails::class, 'booked_flat_id', 'id');
    }
    public function emis()
    {
        return $this->hasMany(EmiPayment::class, 'price_id');
    }
    public function invoices()
    {
        return $this->hasOne(Invoices::class, 'price_id');
    }
}
