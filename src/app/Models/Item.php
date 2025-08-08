<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'img_pass',
        'condition',
        'name',
        'brand',
        'detail',
        'price',
    ];
    public function categories()
    {
        return $this->belongsToMany('App\Models\Category')
            ->withTimestamps();
    }
    public function comments()
    {
        return $this->belongsToMany('App\Models\User', 'comments')
            ->withPivot('detail')
            ->withTimestamps();
    }
    public function purchase()
    {
        return $this->hasOne('App\Models\Purchase');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function favUsers()
    {
        return $this->belongsToMany('App\Models\User', 'favorites')
            ->withTimestamps();
    }
    public function scopeKeyWordLike($query, $keyword)
    {
        if (!empty($keyword)) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }
    }
    public function scopeNonUser($query, $userId)
    {
        if (!empty($userId)) {
            $query->where('user_id', '<>', $userId);
        }
    }
}
