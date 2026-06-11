<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int|string $vill_id
 * @property string     $vill_name
 * @property int|string $gp_id
 */
class Village extends Model
{
    protected $table = 'village';
    protected $fillable = [
        'vill_sn',
        'vill_id',
        'vill_uid',
        'vill_name',
        'gp_id',
        'vill_confirm',
        'vill_conf_date_time',
        'vill_name_correct',
        'vill_confirmed_by',
        'vill_del',
    ];

    public function gp()
    {
        return $this->belongsTo(Gp::class, 'gp_id', 'gp_id');
    }

    public function shgs()
    {
        return $this->hasMany(Shg::class, 'vill_id', 'vill_id');
    }
}
