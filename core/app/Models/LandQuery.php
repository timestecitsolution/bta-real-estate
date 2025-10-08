<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandQuery extends Model
{
    protected $fillable = [
        'owner_name', 'email', 'phone', 'land_address', 'land_info', 'land_area', 'road_size', 'review', 'attachments'
    ];

    protected $casts = [
        'attachments' => 'array',
    ];
}