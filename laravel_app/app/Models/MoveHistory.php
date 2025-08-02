<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MoveHistory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'move_history';

    protected $fillable = [
        'user_id',
        'entity_id',
        'old_latitude',
        'old_longitude',
        'old_address',
        'new_latitude',
        'new_longitude',
        'new_address',
    ];

}
