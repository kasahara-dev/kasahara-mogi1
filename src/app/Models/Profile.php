<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'img_pass',
        'address_id',
    ];
    protected $attributes = [
        'img_pass' => 'img\user-solid-full.svg',
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function address()
    {
        return $this->belongsTo('App\Models\Address');
    }
}
