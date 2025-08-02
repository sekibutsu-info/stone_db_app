<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TagUser extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tag_users';

    protected $fillable = [
        'tag_id',
        'user_id',
    ];

}
