<?php

use App\Models\User;

test('customers cannot access admin routes', function () {
    $user = User::factory()->create(['is_admin' => false]);

    $response = $this->actingAs($user)->get(route('admin.users.index'));

    $response->assertForbidden();
});

test('admins can access admin routes', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $response = $this->actingAs($admin)->get(route('admin.users.index'));

    $response->assertOk();
});

test('admins can create other admins', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $response = $this->actingAs($admin)->post(route('admin.users.store'), [
        'name' => 'New Admin',
        'email' => 'newadmin@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect(route('admin.users.index'));
    $this->assertDatabaseHas('users', [
        'email' => 'newadmin@example.com',
        'is_admin' => true,
    ]);
});
