<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngagementProjectDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'document_type_id',
        'file_path',
    ];

    public function engagement()
    {
        return $this->belongsTo(LandlordEngagement::class, 'project_id');
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id');
    }
}
