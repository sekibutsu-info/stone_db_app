<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suggestion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'suggestions';

    protected $fillable = [
        'closed',
        'entity_id',
        'contributor_id',
        'suggestion',
        'suggested_by',
        'suggested_at',
        'reply',
        'reply_comment',
        'replied_by',
        'replied_at',
        'decision',
        'decision_comment',
        'decided_by',
        'decided_at',
    ];

    protected $casts = [
        'suggested_at' => 'datetime',
        'replied_at' => 'datetime',
        'decided_at' => 'datetime',
    ];
}
