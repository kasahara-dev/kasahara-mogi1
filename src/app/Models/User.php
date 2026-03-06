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
    public function messages()
    {
        return $this->hasMany('App\Models\Message');
    }
    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }
    public function getUnReviewedItems()
    {
        $item_id = [];
        // 購入した商品の中で未評価の商品
        foreach ($this->purchases as $purchase) {
            if ($purchase->reviewed()) {
                ;
            } else {
                $item_id[] = $purchase->item->id;
            }
        }
        // 出品した商品の中で未評価の商品
        foreach ($this->items as $item) {
            if ($item->purchase()->exists()) {
                if ($item->purchase->reviewed()) {
                    ;
                } else {
                    $item_id[] = $item->id;
                }
            }
        }
        if(Item::exists()){
            $items = Item::whereIn('id', $item_id);
        }else{
            $items=Item::make();
        }
        return $items;
    }
    public function getRatesCount()
    {
        $count = 0;
        if(Item::exists()){
            if(Review::where('user_id','<>',$this->id)->exists()){
                $purchaseIds = Review::where('user_id','<>',$this->id)->pluck('purchase_id');
                // 購入者からの評価
                $itemIds = Item::where('user_id',$this->id)->pluck('id');
                $count += Purchase::whereIn('item_id',$itemIds)->whereIn('id',$purchaseIds)->count();
                // 出品者からの評価
                $count += Purchase::where('user_id',$this->id)->whereIn('id',$purchaseIds)->count();
            }
        }
        return $count;
    }
    public function getRatesAvg(){
        if($this->getRatesCount() == 0){
            return 0;
        }else{
            $purchaseIds = Review::where('user_id','<>',$this->id)->pluck('purchase_id');
            $itemIds = Item::where('user_id',$this->id)->pluck('id');
            $soldPurchaseIds = Purchase::whereIn('item_id',$itemIds)->pluck('id');
            $by_purchaser = Review::whereIn('purchase_id',$soldPurchaseIds)->pluck('rate');
            $boughtPurchaseIds = Purchase::where('user_id',$this->id)->pluck('id');
            $by_seller = Review::whereIn('purchase_id',$boughtPurchaseIds)->pluck('rate');
            $by_all = $by_purchaser->merge($by_seller)->avg();
            return $by_all;
        }
    }
}
