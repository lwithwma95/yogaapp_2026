<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int|string    $block_id
 * @property string        $block_name
 * @property int|string    $district_id
 * @property District|null $district
 */
class Block extends Model
{
    protected $table = 'block';
    protected $fillable = [
        'block_uid',
        'block_name',
        'district_id',
        'block_confirm',
        'block_name_correct',
        'block_locked',
        'block_blsc_reco_pdf',
        'block_lock_final',
        'block_ibank',
        'block_idate',
        'bpm',
        'contact',
    ];
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'district_id');
    }
    public function gps()
    {
        return $this->hasMany(Gp::class, 'block_id', 'block_id');
    }
}
