<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingQuery extends Model
{
        protected $fillable = [
        'full_name',
        'email',
        'phone',
        'nid_no',
        'passport_no',
        'birth_certificate_no',
        'project_id',
        'flat_id',
        'preferred_date',
        'message',
        'nid_front_pic',
        'nid_back_pic',
    ];

}