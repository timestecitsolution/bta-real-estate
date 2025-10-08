<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlatDocuments extends Model
{
    use HasFactory;


    protected $fillable = [
        'price_id',
        'document_type_id',
        'file_path'
    ];

    public function price()
    {
        return $this->belongsTo(PriceModel::class);
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }
}
