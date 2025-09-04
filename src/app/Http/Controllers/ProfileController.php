<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.profile');
    }
    public function show(Request $request)
    {
        if ($request->has('page')) {
            $tab = $request->input('page');
        } else {
            $tab = 'sell';
        }
        $user = Auth::user();
        if ($tab == 'sell') {
            $items = $user->items();
        } else {
            $purchases = $user->purchases()->pluck('item_id');
            $items = Item::whereIn('id', $purchases);
        }
        $items->orderBy('updated_at', 'desc')->orderBy('id', 'desc')->with('purchase');
        // 表示商品取得
        if (!is_null($items)) {
            $items = $items->get();
        }
        return view('profile.mypage', compact('tab', 'items'));
    }
}
