<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
        protected $fillable = [
        'purchase_id',
        'user_id',
        'detail',
        'img_path',
        'read',
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
