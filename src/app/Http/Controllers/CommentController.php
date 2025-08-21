<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        if (isset($_POST['send-comment'])) {
            $item = $request->itemId;
            $comment = $request->commentInput;
            Auth::user()->comItems()->attach($item, ['detail' => $comment]);
        } else {
            $item = $request->favorite;
            Auth::user()->favItems()->attach($item);
        }
        return redirect('/item/' . $item);
    }
    public function destroy(Request $request)
    {
        $item = $request->favorite;
        Auth::user()->favItems()->detach($item);
        return redirect('/item/' . $item);
    }
}
