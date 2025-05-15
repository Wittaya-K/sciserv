<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelatedDepartment extends Model
{
    use SoftDeletes;

    protected $table = "related_department";

    protected $fillable = [
        'id_related_departments',
        'related_departments',
    ];
}
