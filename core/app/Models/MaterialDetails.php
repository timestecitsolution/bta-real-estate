<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'price_id',
        'material_type_id',
        'details',
        'change_details',
        'admin_note',
        'status'
    ];
}
