<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;

    protected $table = 'tags';

    public function projects()
    {
        return $this->belongsToMany(
            Topics::class, 
            'smartend_topic_tags', 
            'tag_id', 
            'topic_id'
        );
    }
}
