<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int|string $district
 * @property int|string $block
 * @property string     $name
 * @property string     $email
 * @property string     $role
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [

        'name',
        'district',
        'block',
        'email',
        'password',
        'role',

    ];

    protected $hidden = [

        'password',
        'remember_token',

    ];

    protected function casts(): array
    {
        return [

            'email_verified_at' => 'datetime',
            'password' => 'hashed',

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function districtData()
    {
        return $this->belongsTo(
            District::class,
            'district',
            'district_id'
        );
    }

    public function blockData()
    {
        return $this->belongsTo(
            Block::class,
            'block',
            'block_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    public function isAdmin()
    {
        return $this->role === 'Admin';
    }

    public function isDistrict()
    {
        return $this->role === 'District';
    }

    public function isBlock()
    {
        return $this->role === 'Block';
    }
}