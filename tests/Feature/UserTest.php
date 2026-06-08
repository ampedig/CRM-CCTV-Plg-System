<?php

use App\Models\User;

test('users index page can be rendered for authenticated users', function () {
    $user = User::factory()->create(['role' => 'admin']);

    $response = $this
        ->actingAs($user)
        ->get(route('users.index'));

    $response->assertOk();
});

test('users index page redirects guests to login page', function () {
    $response = $this->get(route('users.index'));

    $response->assertRedirect(route('login'));
});

test('admin can create a new user with valid data', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this
        ->actingAs($admin)
        ->post(route('users.store'), [
            'name' => 'New User',
            'email' => 'new.user@example.com',
            'password' => 'password123',
            'role' => 'sales',
        ]);

    $response->assertRedirect(route('users.index'));
    $this->assertDatabaseHas('users', [
        'name' => 'New User',
        'email' => 'new.user@example.com',
        'role' => 'sales',
    ]);
});

test('creating user requires unique email', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $existingUser = User::factory()->create(['email' => 'duplicate@example.com']);

    $response = $this
        ->actingAs($admin)
        ->post(route('users.store'), [
            'name' => 'Other User',
            'email' => 'duplicate@example.com',
            'password' => 'password123',
            'role' => 'sales',
        ]);

    $response->assertSessionHasErrors('email');
});

test('admin can update user data', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['role' => 'sales']);

    $response = $this
        ->actingAs($admin)
        ->put(route('users.update', $user->id), [
            'name' => 'Updated Name',
            'email' => 'updated.email@example.com',
            'role' => 'admin',
        ]);

    $response->assertRedirect(route('users.index'));
    $user->refresh();
    $this->assertSame('Updated Name', $user->name);
    $this->assertSame('updated.email@example.com', $user->email);
    $this->assertSame('admin', $user->role);
});

test('admin can delete other users', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['role' => 'sales']);

    $response = $this
        ->actingAs($admin)
        ->delete(route('users.destroy', $user->id));

    $response->assertRedirect(route('users.index'));
    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});

test('admin cannot delete themselves', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this
        ->actingAs($admin)
        ->delete(route('users.destroy', $admin->id));

    $response->assertRedirect(route('users.index'));
    $response->assertSessionHas('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
    $this->assertDatabaseHas('users', ['id' => $admin->id]);
});
