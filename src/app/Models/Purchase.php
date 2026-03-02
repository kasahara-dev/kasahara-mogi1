<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
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
        'status',
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }
    public function messages()
    {
        return $this->hasMany('App\Models\Message');
    }
    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }
    public function unreadMessagesCount()
    {
        // $count = 0;
        // if($this->messages->where('messages.user_id','<>', Auth::id())->where('read',0)->exists){
            $count = $this->messages->where('messages.user_id','<>', Auth::id())->where('read',0)->count();
            // \Log::info('messages user id is '.$this->messages()->user_id.'auth id is '.Auth::id());
        // }
        return $count;
    }
}
