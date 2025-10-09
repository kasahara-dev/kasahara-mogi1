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
            $page = $request->input('page');
        } else {
            $page = 'sell';
        }
        $user = Auth::user();
        if ($page == 'sell') {
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
        return view('profile.mypage', compact('page', 'items'));
    }
    public function update(ProfileRequest $request)
    {
        $profile = Profile::where('user_id', Auth::user()->id)->first();
        if (is_null($profile->address_id)) {
            $address = Address::create([
                'post_number' => $request->post_number,
                'address' => $request->address,
                'building' => $request->building,
            ]);
            $profile->update([
                'address_id' => $address->id,
            ]);
        } else {
            Address::find($profile->address_id)->update([
                'post_number' => $request->post_number,
                'address' => $request->address,
                'building' => $request->building,
            ]);
        }
        Auth::user()->update([
            'name' => $request->name
        ]);
        if ($request->hasFile('user_img_input')) {
            $file = $request->file('user_img_input');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('profile', $file, $fileName);
            $profile->update([
                'img_path' => 'storage/' . $path,
            ]);
        }
        if (session('from') == 'register') {
            session()->forget('from');
            return redirect('/?tab=mylist');
        } else {
            session()->forget('from');
            return redirect('/mypage');
        }
    }
}
