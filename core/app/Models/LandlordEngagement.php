<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandlordEngagement extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'number_of_parking',
        'number_of_gas_connection',
        'number_of_utility',
        'landlord_id',
        'flat_id',
    ];

    // ---- RELATIONSHIPS ----

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
        return $this->belongsTo(Contact::class, 'landlord_id');
    }

    public function flatDocuments()
    {
        return $this->hasMany(EngagementFlatDocument::class, 'engagement_id');
    }

    public function materials()
    {
        return $this->hasMany(EngagementMaterial::class, 'engagement_id');
    }
}
