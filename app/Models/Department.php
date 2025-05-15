<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

    protected $table = "department";

    protected $fillable = [
        'department_name',
        'group_name',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
