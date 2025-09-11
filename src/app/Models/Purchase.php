<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'user_id',
        'user_name',
        'payment',
        'post_number',
        'address',
        'building',
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }
}
