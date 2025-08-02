<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddSpHistory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'add_sp_history';

    protected $fillable = [
        'user_id',
        'entity_id',
        'property',
        'value',
    ];

}
