<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceRequest extends Model
{
    use SoftDeletes;

    protected $table = "service_request";

    protected $fillable = [
        'service_request_name',
        'department_id',
        'department_name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
