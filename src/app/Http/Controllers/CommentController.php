<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $item = $request->favorite;
        return redirect('/item/' . $item);
    }
    public function destroy(Request $request)
    {
        $item = $request->favorite;
        return redirect('/item/' . $item);
    }
}
