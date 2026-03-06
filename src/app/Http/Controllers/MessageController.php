<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Message;
use Storage;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    public function create($purchase_id)
    {
        $purchase = Purchase::find($purchase_id);
        $messages = $purchase->messages()->orderBy('created_at')->get();
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
    public function store(CreateMessageRequest $request,$purchase_id){
        $new_message = $request->new_message_text;
        if($request->hasFile('message_img_input')){
            $file = $request->file('message_img_input');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('message', $file, $fileName);
            $setPath = 'storage/' . $path;
        }else{
            $setPath = '';
        }
        Message::create([
            'user_id' => Auth::user()->id,
            'purchase_id' => $purchase_id,
            'detail' => $new_message,
            'img_path' => $setPath,
        ]);
        return back();
    }
    public function update(UpdateMessageRequest $request,$purchase_id){
        $new_message = $request->message[$request->message_id];
        Message::find($request->message_id)
            ->update(['detail' => $new_message]);
        return back();
    }
    public function destroy(Request $request,$purchase_id){
        Message::destroy($request->message_id);
        return back();
    }
}
