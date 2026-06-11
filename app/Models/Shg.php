<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int|string    $shg_id
 * @property string        $shg_code
 * @property string        $shg_name
 * @property int|string    $vill_id_new
 * @property string        $status
 * @property Village|null  $village
 */
class Shg extends Model
{

    protected $table = 'shg';
    public $timestamps = false;
    protected $fillable = [
        'shg_id',
        'shg_uid',
        'vill_id',
        'shg_code',
        'shg_name',
        'shg_dof',
        'shg_acno',
        'status',
        'vill_id',
        'shg_shift_status',
        'shg_shift_date_time',
        'shg_shift_by',
        'shg_accept_status',
        'shg_action_dt',
        'sv_id',
        'js_ccp_id',
        'ks_ccp_id',
        'ps_ccp_id',
        'bs_ccp_id',
        'venue_id',
    ];

    public function members()
    {
        return $this->hasMany(ShgMember::class, 'shg_code', 'shg_code');
    }
    public function village()
    {
        return $this->belongsTo(Village::class, 'vill_id_new', 'vill_id');
    }
}
