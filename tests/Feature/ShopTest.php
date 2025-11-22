<?php

use App\Models\Product;
use App\Models\User;

test('guest can view shop index', function () {
    Product::factory()->count(3)->create();

    $response = $this->get(route('shop.index'));

    $response->assertStatus(200);
    $response->assertViewHas('products');
});

test('guest can view product details', function () {
    $product = Product::factory()->create();

    $response = $this->get(route('shop.show', $product));

    $response->assertStatus(200);
    $response->assertSee($product->name);
});

test('guest cannot buy product', function () {
    $product = Product::factory()->create();

    $response = $this->post(route('shop.buy', $product));

    $response->assertRedirect(route('login'));
});

test('authenticated user can buy product', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $response = $this->actingAs($user)->post(route('shop.buy', $product));

    $response->assertRedirect(route('shop.index'));
    $this->assertDatabaseHas('orders', [
        'user_id' => $user->id,
        'status' => 'pending',
    ]);
    $this->assertDatabaseHas('order_product', [
        'product_id' => $product->id,
        'quantity' => 1,
        'price_cents' => $product->price_cents,
    ]);
});
