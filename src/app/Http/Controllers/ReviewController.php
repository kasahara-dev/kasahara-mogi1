<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
class ReviewController extends Controller
{
    public function store(Request $request,$purchase_id){
        $rate = $request->rate;
        Review::create([
            'purchase_id' => $purchase_id,
            'user_id' => Auth::id(),
            'rate' => $rate,
        ]);
        return redirect('/');
    }
}
