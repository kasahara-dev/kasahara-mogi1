<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Message;
class MessageController extends Controller
{
    public function create($purchase_id)
    {
        $purchase = Purchase::find($purchase_id);
        $messages = $purchase->messages()->get();
        // 未読から既読へ変更
        Message::where('purchase_id',$purchase_id)
            ->where('user_id','<>',Auth::id())
            ->where('read',0)
            ->update(['read' => 1]);
        if($purchase->user_id == Auth::id()){
            $target_user = User::find($purchase->item->user_id);
            $purchaser = true;
        }else{
            $target_user = User::find($purchase->user_id);
            $purchaser = false;
        }
        $other_items = Auth::user()
            ->getUnReviewedItems()
            ->where('id','<>',$purchase->item->id)
            ->get();
        return view('message.message', compact('purchase','messages','target_user','purchaser','other_items'));
    }
}
