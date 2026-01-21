<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientNotice extends Model
{
    use HasFactory;
    protected $table = 'client_notice';
    
    protected $fillable = [
        'client_id',
        'subject_id',
        'notice_body',
        'created_by',
    ];
    public function subject()
    {
        return $this->belongsTo(ClientApplicationSubject::class, 'subject_id');
    }
    public function client()
    {
        return $this->belongsTo(Contact::class, 'client_id');
    }
}
