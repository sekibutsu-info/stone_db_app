<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeleteHistory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'delete_history';

    protected $fillable = [
        'user_id',
        'property_id',
    ];

}
