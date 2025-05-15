<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssignTask extends Model
{
    use SoftDeletes;

    protected $table = "assign_tasks";
    
    protected $fillable = [
        'username',
		'service_id',
        'department_id',
    ];
}
