<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $items = Item::orderBy('updated_at', 'desc')->with('purchase');
        if (isset($request->tab)) {
            if ($request->tab == 'mylist') {
                if (Auth::check()) {
                    // 認証済みユーザーに対する処理
                    $user = Auth::user();
                    $items = $user->favItems()->orderBy('updated_at', 'desc')->with('purchase');
                } else {
                    // 未認証ユーザーに対する処理
                    $items = null;
                }
            }
            $tab = $request->tab;
        } else {
            $tab = '';
        }
        // 自分が出品した商品は表示しない
        if (Auth::check()) {
            // 認証済みユーザーに対する処理
            $user = Auth::user();
            $items->NonUser($user->id);
        } else {
            // 未認証ユーザーに対する処理
        }
        // キーワード検索
        if (!empty($request->keyword)) {
            $keyword = $request->keyword;
            if (!empty($items)) {
                $items->KeyWordLike($request->keyword);
            }
            $request->session()->put('keyword', $request->keyword);
        } else {
            $keyword = '';
        }
        // 表示商品取得
        if (!is_null($items)) {
            $items = $items->get();
        }
        return view('item.index', compact(['items', 'keyword', 'tab']));
    }
    public function show(Request $request, $item_id)
    {
        $keyword = '';
        $tab = '';
        $item = Item::where('id', $item_id)->with('categories')->with('purchase')->with('favUsers')->first();
        $comments = Comment::where('item_id', $item_id)->with('user')->get();
        $commentsCount = count($comments);
        $favUsersCount = count($item->favUsers);
        return view('item.detail', compact(['keyword', 'tab', 'item_id', 'item', 'comments', 'commentsCount', 'favUsersCount']));
    }
}
