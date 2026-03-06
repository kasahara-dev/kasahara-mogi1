<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchase_id',
        'user_id',
        'rate',
    ];
    public function purchase()
    {
        return $this->belongsTo('App\Models\Purchase');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}