<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Shg;

class Venue extends Model
{
    protected $table = 'venue';
    protected $fillable = [
        'village_id',
        'venue_name',
        'capacity',
        'photo',
        'monitored_by',
    ];
    // VILLAGE RELATION
    public function village()
    {
        return $this->belongsTo(
            Village::class,
            'village_id',
            'vill_id'
        );
    }
    // SHG RELATION
    public function shg()
    {
        return $this->belongsTo(
            Shg::class,
            'shg_code',
            'shg_code'
        );
    }
    // MONITORING MEMBER
    public function monitor()
    {
        return $this->belongsTo(
            ShgMember::class,
            'monitored_by',
            'mem_uid'
        );
    }
    public function cadre()
    {
        return $this->belongsTo(
            ShgMember::class,
            'monitored_by',
            'mem_code'
        );
    }
}