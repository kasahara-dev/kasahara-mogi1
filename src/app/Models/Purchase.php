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
        $count = $this->messages()->where('messages.user_id','<>', Auth::id())->where('read',0)->count();
        return $count;
    }
    public function reviewed(){
        $reviewed = false;
        if($this->reviews()->exists()){
            if($this->reviews()->where('reviews.user_id',Auth::id())->exists()){
                $reviewed = true;
            }
        }
        return $reviewed;
    }
}
