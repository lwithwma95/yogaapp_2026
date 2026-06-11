<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Analytics extends Model
{
    protected $table = 'analytics';

    protected $fillable = [
        'district_code',
        'district_name',
        'count',
        'total',
    ];

    protected $casts = [
        'count' => 'integer',
        'total' => 'integer',
    ];
}
