<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentralApplicationAttachment extends Model
{
    use HasFactory;
    protected $fillable = [
        'central_application_id',
        'file_path',
        'file_name',
        'file_size',
    ];
}
