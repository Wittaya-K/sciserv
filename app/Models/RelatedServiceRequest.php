<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelatedServiceRequest extends Model
{
    use SoftDeletes;

    protected $table = "related_service_request";

    protected $fillable = [
        'id_related_service_requests',
        'related_service_requests',
    ];
}
