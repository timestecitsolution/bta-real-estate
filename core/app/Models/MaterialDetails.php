<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'booked_flat_id',
        'project_id',
        'flat_id',
        'material_type_id',
        'material_document',
        'details',
        'change_details',
        'admin_note',
        'status'
    ];
}
