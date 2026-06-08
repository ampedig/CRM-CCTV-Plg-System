<?php

use App\Models\Customer;
use App\Models\ChatHistory;

test('it can store a chat history record', function () {
    $customer = Customer::create([
        'full_name' => 'John Doe',
        'whatsapp_number' => '08123456789',
        'is_active' => 1
    ]);

    $chat = ChatHistory::create([
        'customer_id' => $customer->id,
        'whatsapp_number' => '08123456789',
        'message' => 'Hello, I want to buy a CCTV package.'
    ]);

    $this->assertDatabaseHas('chat_histories', [
        'customer_id' => $customer->id,
        'whatsapp_number' => '08123456789',
        'message' => 'Hello, I want to buy a CCTV package.'
    ]);

    $this->assertInstanceOf(Customer::class, $chat->customer);
    $this->assertEquals($customer->id, $chat->customer->id);

    $this->assertTrue($customer->chatHistories->contains($chat));
});

test('it deletes chat history when the customer is deleted', function () {
    $customer = Customer::create([
        'full_name' => 'Jane Doe',
        'whatsapp_number' => '08987654321',
        'is_active' => 1
    ]);

    $chat = ChatHistory::create([
        'customer_id' => $customer->id,
        'whatsapp_number' => '08987654321',
        'message' => 'Test message'
    ]);

    $customer->delete();

    $this->assertDatabaseMissing('chat_histories', [
        'id' => $chat->id
    ]);
});
