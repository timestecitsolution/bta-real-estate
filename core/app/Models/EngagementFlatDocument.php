<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngagementFlatDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'engagement_id',
        'document_type_id',
        'file_path',
    ];

    public function engagement()
    {
        return $this->belongsTo(LandlordEngagement::class, 'engagement_id');
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id');
    }
}
