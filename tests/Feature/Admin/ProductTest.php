<?php

use App\Models\Product;
use App\Models\User;

test('admin can view product list', function () {
    $user = User::factory()->create(['is_admin' => true]);
    $response = $this->actingAs($user)->get(route('admin.products.index'));

    $response->assertStatus(200);
});

test('admin can create product', function () {
    $user = User::factory()->create(['is_admin' => true]);
    $response = $this->actingAs($user)->post(route('admin.products.store'), [
        'name' => 'New Product',
        'price_cents' => 1000,
    ]);

    $response->assertRedirect(route('admin.products.index'));
    $this->assertDatabaseHas('products', [
        'name' => 'New Product',
        'price_cents' => 1000,
    ]);
});

test('admin can update product', function () {
    $user = User::factory()->create(['is_admin' => true]);
    $product = Product::factory()->create();

    $response = $this->actingAs($user)->put(route('admin.products.update', $product), [
        'name' => 'Updated Product',
        'price_cents' => 2000,
    ]);

    $response->assertRedirect(route('admin.products.index'));
    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => 'Updated Product',
        'price_cents' => 2000,
    ]);
});

test('admin can delete product', function () {
    $user = User::factory()->create(['is_admin' => true]);
    $product = Product::factory()->create();

    $response = $this->actingAs($user)->delete(route('admin.products.destroy', $product));

    $response->assertRedirect(route('admin.products.index'));
    $this->assertDatabaseMissing('products', [
        'id' => $product->id,
    ]);
});

test('guest cannot access admin routes', function () {
    $response = $this->get(route('admin.products.index'));
    $response->assertRedirect(route('login'));
});
