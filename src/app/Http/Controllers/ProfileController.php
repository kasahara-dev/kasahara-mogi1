<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Profile;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Str;
use Storage;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        if (isset($request->from)) {
            $request->session()->put('from', 'header');
        } else {
            $request->session()->put('from', 'register');
        }
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
    public function update(ProfileRequest $request)
    {
        $profile = Profile::where('user_id', Auth::user()->id)->first();
        $address = Address::create([
            'post_number' => $request->postNumber,
            'address' => $request->address,
            'building' => $request->building,
        ]);
        Auth::user()->update([
            'name' => $request->name
        ]);
        if ($request->hasFile('userImgInput')) {
            $file = $request->file('userImgInput');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('profile', $file, $fileName);
            $url = Storage::disk('public')->url($path);
            $profile->update([
                'address_id' => $address->id,
                'img_path' => 'storage/' . $path,
            ]);
        } else {
            $profile->update([
                'address_id' => $address->id,
            ]);
        }
        if (session('from') == 'register') {
            session()->forget('from');
            return redirect('/');
        } else {
            session()->forget('from');
            return redirect('/mypage');
        }
    }
}
