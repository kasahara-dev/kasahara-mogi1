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
    public function receiverId()
    {
        if($this->purchase->user_id == $this->user_id){
            $receiver_id = $this->purchase->item->user_id;
        }else{
            $receiver_id = $this->purchase->user_id;
        }
        return $receiver_id;
    }
    public function scopeUnread($query){
        return $query->where('read',0);
    }
}