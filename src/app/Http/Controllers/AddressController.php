<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function create(Request $request, $item_id)
    {
        if (isset($request->addressId)) {
            $addressId = $request->addressId;
            $address = Address::where('id', $addressId)->first();
        } else {
            $address = null;
        }
        return view('address.address', compact(['item_id', 'address']));
    }
    public function store(AddressRequest $request, $item_id)
    {
        $address = Address::create([
            'post_number' => $request->postNumber,
            'address' => $request->address,
            'building' => $request->building,
        ]);
        $addressId = $address->id;
        return redirect()->route('purchase', compact('item_id', 'addressId'));
    }
}