<?php

use App\Models\Product;
use App\Models\User;

test('user can add item to cart', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $response = $this->actingAs($user)->post(route('cart.store'), [
        'product_id' => $product->id,
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('cart_items', [
        'product_id' => $product->id,
        'quantity' => 1,
    ]);
});

test('user can view cart', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();
    $cart = $user->cart()->create();
    $cart->items()->create(['product_id' => $product->id, 'quantity' => 1]);

    $response = $this->actingAs($user)->get(route('cart.index'));

    $response->assertOk();
    $response->assertSee($product->name);
});

test('user can update cart item quantity', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();
    $cart = $user->cart()->create();
    $item = $cart->items()->create(['product_id' => $product->id, 'quantity' => 1]);

    $response = $this->actingAs($user)->patch(route('cart.update', $item), [
        'quantity' => 5,
    ]);

    $response->assertRedirect(route('cart.index'));
    $this->assertDatabaseHas('cart_items', [
        'id' => $item->id,
        'quantity' => 5,
    ]);
});

test('user can remove item from cart', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();
    $cart = $user->cart()->create();
    $item = $cart->items()->create(['product_id' => $product->id, 'quantity' => 1]);

    $response = $this->actingAs($user)->delete(route('cart.destroy', $item));

    $response->assertRedirect(route('cart.index'));
    $this->assertDatabaseMissing('cart_items', [
        'id' => $item->id,
    ]);
});
