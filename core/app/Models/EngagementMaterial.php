<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngagementMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'engagement_id',
        'material_type_id',
        'material_details',
        'material_documents',
    ];

    public function engagement()
    {
        return $this->belongsTo(LandlordEngagement::class, 'engagement_id');
    }

    public function materialType()
    {
        return $this->belongsTo(MaterialType::class, 'material_type_id');
    }
}
