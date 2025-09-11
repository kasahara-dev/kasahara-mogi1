<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_number',
        'address',
        'building',
    ];
    public function profile()
    {
        return $this->belongsTo('App\Models\Profile');
    }
}
