<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockAnalytics extends Model
{
    protected $table = 'block_analytics';

    protected $fillable = [
        'block_id',
        'block_name',
        'district_id',
        'total_shg',
        'registered',
        'total',
        'attendance',
    ];

    protected $casts = [
        'total_shg'  => 'integer',
        'registered' => 'integer',
        'total'      => 'integer',
        'attendance' => 'integer',
    ];
}
