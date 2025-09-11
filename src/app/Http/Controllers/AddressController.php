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
        $payment = $request->payment;
        $post_number = session('post_number');
        $address = session('address');
        $building = session('building');
        // if (isset($request->address)) {
        //     $addressId = $request->addressId;
        //     $address = Address::where('id', $addressId)->first();
        // } else {
        //     $address = null;
        // }
        return view('address.address', compact(['item_id', 'payment', 'post_number', 'address', 'building']));
    }
    public function store(AddressRequest $request, $item_id)
    {
        $payment = $request->payment;
        $post_number = $request->post_number;
        $address = $request->address;
        $building = $request->building;
        // $address = Address::create([
        //     'post_number' => $request->postNumber,
        //     'address' => $request->address,
        //     'building' => $request->building,
        // ]);
        // $addressId = $address->id;
        return redirect()->route('purchase', compact('item_id', 'payment', 'post_number', 'address', 'building'));
    }
}