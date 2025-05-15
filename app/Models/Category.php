<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table = "category";

    protected $fillable = [
        'user_id',
        'name',
        'status',
        'delete_flag',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
