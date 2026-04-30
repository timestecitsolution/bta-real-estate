<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'type', 'action',
        'title', 'message', 'url', 'icon', 'seen_at'
    ];

    protected $casts = ['seen_at' => 'datetime'];

    public function scopeUnseen($query)
    {
        return $query->whereNull('seen_at');
    }
}
