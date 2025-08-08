<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $items = Item::orderBy('updated_at', 'desc')->with('purchase');
        $myList = false;
        if (isset($request->tab)) {
            if ($request->tab == 'mylist') {
                $myList = true;
                if (Auth::check()) {
                    // 認証済みユーザーに対する処理
                    $user = Auth::user();
                } else {
                    // 未認証ユーザーに対する処理
                }
            }
        }
        if (Auth::check()) {
            // 認証済みユーザーに対する処理
            $user = Auth::user();
            $items->NonUser($user->id);
        } else {
            // 未認証ユーザーに対する処理
        }
        if (isset($request->search)) {
            $keyword = $request->search;
            $items->KeyWordLike($request->search);
        } else {
            $keyword = '';
        }
        $items = $items->get();
        return view('item.index', compact(['items', 'keyword', 'myList']));
    }
}
