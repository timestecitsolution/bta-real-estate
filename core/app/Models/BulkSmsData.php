<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkSmsData extends Model
{
    use HasFactory;

    protected $table = 'bulk_sms_data';

    protected $fillable = [
        'phone_number',
        'message',
        'status'
    ];
}
