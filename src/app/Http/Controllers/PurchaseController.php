<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Address;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
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
        require_once '../vendor/autoload.php';
        // require_once '../secrets.php';

        $item = Item::where('id', $item_id)->first();

        Purchase::create([
            'item_id' => $item_id,
            'user_id' => Auth::user()->id,
            'payment' => $request->payment,
            'address_id' => $request->address,
        ]);

        if ($request->payment == '1') {
            $payment = 'konbini';
        } else {
            $payment = 'card';
        }

        Stripe::setApiKey(config('services.stripe.secret_key'));
        header('Content-Type: application/json');
        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => [$payment],
            'metadata' => [
                'item_id' => $item->id,
            ],
            'line_items' => [
                [
                    # Provide the exact Price ID (e.g. price_1234) of the product you want to sell
                    'price_data' => [
                        'currency' => 'JPY',
                        'product_data' => [
                            'name' => $item->name,
                        ],
                        'unit_amount' => $item->price,
                    ],
                    'quantity' => 1,
                ]
            ],
            'payment_intent_data' => [
                'metadata' => [
                    'item_id' => $item->id,
                ],
            ],
            'mode' => 'payment',
            'success_url' => 'http://localhost/',
            'cancel_url' => 'http://localhost/',
        ]);

        header("HTTP/1.1 303 See Other");
        header("Location: " . $checkout_session->url);

    }
}