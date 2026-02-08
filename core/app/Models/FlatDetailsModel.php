<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlatDetailsModel extends Model
{
    use HasFactory;
    protected $table = 'flat_details';
    protected $fillable = [
        'project_id',
        'flat_name',
        'flat_size',
    ];
    public function project()
    {
        return $this->belongsTo(Topic::class, 'project_id');
    }
}
