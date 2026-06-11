<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cpp extends Model
{
    protected $table = 'ccp';
    protected $fillable = [
        'shg_id',
        'shg_uid ',
        'vill_id',
        'shg_code',
        'shg_name',
        'shg_dof ',
        'shg_acno',
        'status',
        'vill_id',
        'shg_shift_status ',
        'shg_shift_date_time',
        'shg_shift_by',
        'shg_accept_status',
        'shg_action_dt',
        'sv_id',
        'js_ccp_id ',
        'ks_ccp_id ',
        'ps_ccp_id',
        'bs_ccp_id',
    ];
}
