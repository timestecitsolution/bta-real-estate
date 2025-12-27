<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Topics;

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
        protected $casts = [
            'project_id' => 'integer',
        ];


    public function project()
    {
        return $this->belongsTo(Topics::class, 'project_id', 'id');
    }

}