<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $items = Item::orderBy('updated_at', 'desc')->get();
        return view('item.index', compact(['items',]));
    }
}
