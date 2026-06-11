<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'district';
    protected $fillable = [
        'district_id',
        'district_name',
        'district_uid',
        'shg_shift_complete',
        'district_lock',
        'dpm',
        'contact',
    ];
    public function blocks()
    {
        return $this->hasMany(Block::class, 'district_id', 'district_id');
    }
}
