<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
class PurchaseController extends Controller
{
    public function create(Request $request, $item_id)
    {
        if ($request->filled('payment')) {
            $payment = $request->payment;
        } else {
            $payment = '';
        }
        if ($request->has('address')) {
            $post_number = $request->post_number;
            $address = $request->address;
            $building = $request->building;
        } elseif (isset(Auth::user()->profile->address)) {
            $post_number = Auth::user()->profile->address->post_number;
            $address = Auth::user()->profile->address->address;
            $building = Auth::user()->profile->address->building;
        } else {
            $post_number = '';
            $address = '';
            $building = '';
        }
        session([
            'post_number' => $post_number,
            'address' => $address,
            'building' => $building,
        ]);
        $item = Item::where('id', $item_id)->first();
        return view('purchase.purchase', compact(['item', 'payment', 'post_number', 'address', 'building']));
    }
    public function store(PurchaseRequest $request, $item_id)
    {
        session()->flash('address', session('address'));

        $item = Item::where('id', $item_id)->first();
        Purchase::create([
            'item_id' => $item_id,
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
            'payment' => $request->payment,
            'post_number' => session('post_number'),
            'address' => session('address'),
            'building' => session('building'),
        ]);

        if ($request->payment == '1') {
            $payment = 'konbini';
        } else {
            $payment = 'card';
        }
        require_once '../vendor/autoload.php';

        Stripe::setApiKey(config('services.stripe.secret_key'));
        header('Content-Type: application/json');
        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => [$payment],
            'metadata' => [
                'item_id' => $item->id,
            ],
            'line_items' => [
                [
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
            'success_url' => env('APP_URL'),
            'cancel_url' => env('APP_URL'),
        ]);

        header("HTTP/1.1 303 See Other");
        header("Location: " . $checkout_session->url);

    }
}