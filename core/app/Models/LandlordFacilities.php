<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandlordFacilities extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id',
        'number_of_parking',
        'number_of_gas_connection',
        'number_of_utility',
    ];
}
