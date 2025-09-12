<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;

class AddressController extends Controller
{
    public function create(Request $request, $item_id)
    {
        $payment = $request->payment;
        $post_number = session('post_number');
        $address = session('address');
        $building = session('building');
        return view('address.address', compact(['item_id', 'payment', 'post_number', 'address', 'building']));
    }
    public function store(AddressRequest $request, $item_id)
    {
        $payment = $request->payment;
        $post_number = $request->post_number;
        $address = $request->address;
        $building = $request->building;
        return redirect()->route('purchase', compact('item_id', 'payment', 'post_number', 'address', 'building'));
    }
}