<?php

use App\Models\User;
use App\Models\Customer;
use App\Models\ChatHistory;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->customer = Customer::create([
        'full_name' => 'John Doe',
        'whatsapp_number' => '08123456789',
        'is_active' => 1
    ]);

    $this->chat = ChatHistory::create([
        'customer_id' => $this->customer->id,
        'whatsapp_number' => '08123456789',
        'message' => 'Need help with CCTV setup'
    ]);
});

test('guest cannot access chat histories', function () {
    $this->get(route('chat-histories.index'))
        ->assertRedirect(route('login'));
});

test('authenticated user can view chat histories index', function () {
    $response = $this
        ->actingAs($this->user)
        ->get(route('chat-histories.index'));

    $response->assertOk()
        ->assertSee('Chat History')
        ->assertSee('John Doe')
        ->assertSee('08123456789');
});

test('authenticated user can search chat histories', function () {
    $otherCustomer = Customer::create([
        'full_name' => 'Jane Smith',
        'whatsapp_number' => '08987654321',
        'is_active' => 1
    ]);

    $otherChat = ChatHistory::create([
        'customer_id' => $otherCustomer->id,
        'whatsapp_number' => '08987654321',
        'message' => 'Looking for pricing'
    ]);

    // Search by message content
    $response1 = $this
        ->actingAs($this->user)
        ->get(route('chat-histories.index', ['search' => 'pricing']));

    $response1->assertOk()
        ->assertSee('Jane Smith')
        ->assertDontSee('John Doe');

    // Search by customer name
    $response2 = $this
        ->actingAs($this->user)
        ->get(route('chat-histories.index', ['search' => 'John']));

    $response2->assertOk()
        ->assertSee('John Doe')
        ->assertDontSee('Jane Smith');
});

test('authenticated user can delete a chat history', function () {
    $response = $this
        ->actingAs($this->user)
        ->delete(route('chat-histories.destroy', $this->chat->id));

    $response->assertRedirect(route('chat-histories.index'))
        ->assertSessionHas('success', 'Riwayat chat berhasil dihapus.');

    $this->assertDatabaseMissing('chat_histories', [
        'id' => $this->chat->id
    ]);
});
