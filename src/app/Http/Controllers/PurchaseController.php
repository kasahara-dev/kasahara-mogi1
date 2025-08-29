<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Address;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function create(Request $request, $item_id)
    {
        if ($request->filled('addressId')) {
            $addressId = $request->addressId;
        } elseif (isset(Auth::user()->profile->address->id)) {
            $addressId = Auth::user()->profile->address->id;
        } else {
            $addressId = '';
        }
        $address = Address::where('id', $addressId)->first();
        $item = Item::where('id', $item_id)->first();
        return view('purchase.purchase', compact(['item', 'address']));
    }
    public function store(PurchaseRequest $request, $item_id)
    {
        Purchase::create([
            'item_id' => $item_id,
            'user_id' => Auth::user()->id,
            'payment' => $request->payment,
            'address_id' => $request->address,
        ]);
        return redirect('/');
    }
}