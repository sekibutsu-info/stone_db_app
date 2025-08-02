<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issue extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'issues';

    protected $fillable = [
        'user_id',
        'entity_id',
        'content',
    ];

}
