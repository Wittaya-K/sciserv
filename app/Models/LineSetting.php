<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LineSetting extends Model
{
    use SoftDeletes;

    protected $table = "line_setting";

    protected $fillable = [
        'line_token',
    ];
}
