<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Item;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Storage;
use Illuminate\Support\Str;


class ItemController extends Controller
{
    public function index(Request $request)
    {
        $items = Item::orderBy('updated_at', 'desc')->orderBy('id', 'desc')->with('purchase');
        if (isset($request->tab)) {
            if ($request->tab == 'mylist') {
                if (Auth::check()) {
                    // 認証済みユーザーに対する処理
                    $user = Auth::user();
                    $items = $user->favItems()->orderBy('updated_at', 'desc')->orderBy('id', 'desc')->with('purchase');
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
    public function show($item_id)
    {
        $item = Item::where('id', $item_id)->with('categories')->with('purchase')->with('favUsers')->first();
        $favorite = false;
        if (Auth::check()) {
            $favItems = Auth::user()->favItems()->pluck('items.id')->all();
            if (in_array($item_id, $favItems)) {
                $favorite = true;
            }
        }
        $comments = Comment::where('item_id', $item_id)->orderBy('updated_at', 'desc')->with('user.profile')->get();
        $commentsCount = count($comments);
        $favUsersCount = count($item->favUsers);
        return view('item.detail', compact(['item_id', 'item', 'comments', 'commentsCount', 'favorite', 'favUsersCount']));
    }
    public function create()
    {
        $categories = Category::all();
        return view('item.sell', compact(['categories']));
    }
    public function store(ExhibitionRequest $request)
    {
        $file = $request->file('item_img_input');
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = Storage::disk('public')->putFileAs('item', $file, $fileName);
        $item = Item::create([
            'user_id' => Auth::user()->id,
            'img_path' => 'storage/' . $path,
            'condition' => $request->condition,
            'name' => $request->itemName,
            'brand' => $request->brandName,
            'detail' => $request->itemInfo,
            'price' => $request->price,
        ]);
        foreach ($request->category as $category) {
            $item->categories()->attach($category);
        }
        return redirect('/mypage');
    }
}
