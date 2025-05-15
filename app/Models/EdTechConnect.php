<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EdTechConnect extends Model
{
    use SoftDeletes;

    protected $table = "edtech_connect";

    protected $fillable = [
        'username',
        'department_name',
        'access_token',
        'status',
    ];
}
