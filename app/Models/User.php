<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'character_id', 'character_owner_hash'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['remember_token'];

    public function ownSigs()
    {
        return $this->hasMany(\App\Models\Signature::class, 'FK_pilot', 'id')->get();
    }

    public function freeSigs()
    {
        return Signature::Where('status', '=', 'free')->orderBy('sig_id', 'desc')->get();
    }
}
