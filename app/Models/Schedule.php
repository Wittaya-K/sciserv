<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes;

    protected $table = "schedule";
    
    protected $fillable = [
        'category',
		'title',
		'description',
		'file',
		'department',
		'service',
		'schedule_from',
		'schedule_to',
        'user_service_required',
        'job_status',
    ];
}
