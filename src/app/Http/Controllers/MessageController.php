<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;
use App\Models\User;
class MessageController extends Controller
{
    public function create($purchase_id)
    {
        $purchase = Purchase::find($purchase_id);
        $messages = $purchase->messages()->get();
        if($purchase->user_id == Auth::id()){
            $target_user = User::find($purchase->item()->user_id);
        }else{
            $target_user = User::find($purchase->user_id);
        }
        return view('message.message', compact('purchase','messages','target_user'));
    }
}
