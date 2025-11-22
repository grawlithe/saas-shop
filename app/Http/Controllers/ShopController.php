<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(): View
    {
        $products = Product::latest()->get();

        return view('shop.index', compact('products'));
    }

    public function show(Product $product): View
    {
        return view('shop.show', compact('product'));
    }

    public function buy(Request $request, Product $product)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return $request->user()->checkout([[
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => $product->name,
                ],
                'unit_amount' => $product->price_cents,
            ],
            'quantity' => 1,
        ]], [
            'success_url' => route('checkout.success', ['product_id' => $product->id]) . '&session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel'),
            'metadata' => ['product_id' => $product->id],
        ]);
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        $productId = $request->get('product_id');

        if (!$sessionId || !$productId) {
            return redirect()->route('shop.index');
        }

        // In a real app, verify the session with Stripe here.
        // For now, we assume success if they hit this URL with a session ID.

        $product = Product::findOrFail($productId);
        $user = Auth::user();

        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'paid',
        ]);

        $order->products()->attach($product->id, [
            'quantity' => 1,
            'price_cents' => $product->price_cents,
        ]);

        return redirect()->route('shop.index')
            ->with('status', 'Order placed successfully!');
    }

    public function cancel()
    {
        return redirect()->route('shop.index')
            ->with('status', 'Order cancelled.');
    }
}
