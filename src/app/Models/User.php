<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
// class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }
    public function comItems()
    {
        return $this->belongsToMany('App\Models\Item', 'comments')
            ->withPivot('detail')
            ->withTimestamps();
    }
    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }
    public function favItems()
    {
        return $this->belongsToMany('App\Models\Item', 'favorites')
            ->withTimestamps();
    }
    public function purchases()
    {
        return $this->hasMany('App\Models\Purchase');
    }
}
