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

    public function buy(Request $request, Product $product): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'pending',
        ]);

        $order->products()->attach($product->id, [
            'quantity' => 1,
            'price_cents' => $product->price_cents,
        ]);

        return redirect()->route('shop.index')
            ->with('status', 'Order placed successfully!');
    }
}
