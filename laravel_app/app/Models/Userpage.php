<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Userpage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'userpages';

    protected $fillable = [
        'user_id',
        'open',
        'comment',
        'twitter',
        'twitter_disp',
        'homepage',
        'contrib',
        'pref',
        'bingo',
    ];

}
