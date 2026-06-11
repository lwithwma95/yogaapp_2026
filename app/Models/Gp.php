<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int|string $gp_id
 * @property string     $gp_name
 * @property int|string $block_id
 */
class Gp extends Model
{
    protected $table = 'gp';

    protected $fillable = [
        'gp_sn',
        'gp_id',
        'gp_uid',
        'gp_name',
        'block_id',
        'gp_assign',
        'gpv_limit',
        'gp_blsc_rej_pdf',
        'gp_blsc_reco_pdf',
        'gp_confirm',
        'gp_conf_date_time',
        'gp_name_correct',
        'gp_confirmed_by',
        'gp_del',
        'gp_lac',
    ];

    public function block()
    {
        return $this->belongsTo(Block::class, 'block_id', 'block_id');
    }

    public function villages()
    {
        return $this->hasMany(Village::class, 'gp_id', 'gp_id');
    }
}