<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int|string  $mem_no
 * @property string      $mem_uid
 * @property string      $shg_code
 * @property string      $mem_code
 * @property string      $mem_name
 * @property string|null $mem_mobile
 * @property int         $yoga2026_registration
 * @property int         $yoga_attendance
 * @property string|null $yoga_selfie
 * @property string|null $yoga_reg_date
 * @property Shg|null    $shg
 */
class ShgMember extends Model
{
    protected $table = 'member';
    protected $primaryKey = 'mem_no';
    protected $fillable = [
        'mem_no',
        'mem_uid',
        'shg_code',
        'mem_code',
        'mem_name',
        'mem_guard_name',
        'mem_mobile',
        'mem_status',
        'alt_mobile',
        'yoga_selfie',
        'yoga2026_registration',
        'yoga_attendance',
        'yoga_token',
        'yoga_reg_date',
        'yoga_cadre',
        'yoga_username',
        'password',
    ];

    public function shg()
    {
        return $this->belongsTo(Shg::class, 'shg_code', 'shg_code');
    }

}