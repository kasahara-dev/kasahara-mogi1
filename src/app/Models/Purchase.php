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
        'payment',
        'address_id',
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function address()
    {
        return $this->belongsTo('App\Models\Address');
    }
    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }
}
