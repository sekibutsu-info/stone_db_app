<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'entities';

    protected $fillable = [
        'user_id',
    ];

}
