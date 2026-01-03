<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentralApplication extends Model
{
    use HasFactory;

    protected $table = 'central_application';

    protected $fillable = [
        'subject_id',
        'body',
        'status',
        'feedback',
        'applied_by',
    ];

    // Relationship with ClientApplicationSubject
    public function subject()
    {
        return $this->belongsTo(ClientApplicationSubject::class, 'subject_id');
    }

    // Relationship with User (creator)
    public function creator()
    {
        return $this->belongsTo(Contact::class, 'applied_by');
    }

    public function feedbacks()
    {
        return $this->hasMany(ApplicationFeedback::class, 'application_id');
    }
}
