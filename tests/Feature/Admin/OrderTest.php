<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\User;

test('admin can view order list', function () {
    $user = User::factory()->create(['is_admin' => true]);
    $order = Order::create([
        'user_id' => $user->id,
        'status' => 'pending',
    ]);
    $product = Product::factory()->create();
    $order->products()->attach($product->id, [
        'quantity' => 2,
        'price_cents' => 1000,
    ]);

    $response = $this->actingAs($user)->get(route('admin.orders.index'));

    $response->assertStatus(200);
    $response->assertSee($user->name);
    $response->assertSee('Pending');
    $response->assertSee('$20.00'); // 2 * 1000 cents = $20.00
});

test('guest cannot access admin orders', function () {
    $response = $this->get(route('admin.orders.index'));
    $response->assertRedirect(route('login'));
});
