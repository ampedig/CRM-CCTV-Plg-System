<?php

use App\Models\Customer;
use App\Models\ChatHistory;
use Illuminate\Support\Carbon;

test('it can process wa webhook for an existing customer and increment counters', function () {
    $customer = Customer::create([
        'full_name' => 'John Doe',
        'whatsapp_number' => '628123456789',
        'is_active' => 1,
        'total_chats_received' => 5,
        'consultation_frequency' => 2,
        'last_consultation_at' => null
    ]);

    // Send webhook with structured format
    $response = $this->postJson('/api/wa/webhook', [
        'sender' => [
            'phone' => '08123456789',
            'name' => 'John Doe'
        ],
        'message' => [
            'text' => 'Hello Wongkito! Testing webhook.'
        ]
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'success',
            'message' => 'Chat message stored and analytics updated successfully.',
            'data' => [
                'customer' => 'John Doe',
                'whatsapp_number' => '628123456789',
                'message' => 'Hello Wongkito! Testing webhook.'
            ]
        ]);

    // Assert chat history is logged
    $this->assertDatabaseHas('chat_histories', [
        'customer_id' => $customer->id,
        'whatsapp_number' => '628123456789',
        'message' => 'Hello Wongkito! Testing webhook.'
    ]);

    $customer->refresh();

    // Assert total chats incremented (5 -> 6)
    $this->assertEquals(6, $customer->total_chats_received);

    // Assert consultation frequency incremented (2 -> 3) since last_consultation_at was null
    $this->assertEquals(3, $customer->consultation_frequency);
    $this->assertNotNull($customer->last_consultation_at);
});

test('it only increments consultation frequency once per day', function () {
    Carbon::setTestNow(Carbon::parse('2026-06-17 10:00:00'));

    $customer = Customer::create([
        'full_name' => 'Jane Smith',
        'whatsapp_number' => '628987654321',
        'is_active' => 1,
        'total_chats_received' => 0,
        'consultation_frequency' => 0,
        'last_consultation_at' => null
    ]);

    // First message - increments frequency (0 -> 1)
    $this->postJson('/api/wa/webhook', [
        'sender' => ['phone' => '628987654321'],
        'message' => ['text' => 'First message']
    ])->assertStatus(200);

    $customer->refresh();
    $this->assertEquals(1, $customer->total_chats_received);
    $this->assertEquals(1, $customer->consultation_frequency);
    $this->assertEquals('2026-06-17 10:00:00', $customer->last_consultation_at->format('Y-m-d H:i:s'));

    // Second message on the same day - should NOT increment consultation frequency, but total_chats_received should increment
    Carbon::setTestNow(Carbon::parse('2026-06-17 14:00:00'));

    $this->postJson('/api/wa/webhook', [
        'sender' => ['phone' => '628987654321'],
        'message' => ['text' => 'Second message']
    ])->assertStatus(200);

    $customer->refresh();
    $this->assertEquals(2, $customer->total_chats_received);
    $this->assertEquals(1, $customer->consultation_frequency); // Remains 1!
    // last_consultation_at is not changed on the same day or we can update it (doesn't matter as long as freq is not incremented)

    // Third message on the next day - should increment consultation frequency (1 -> 2)
    Carbon::setTestNow(Carbon::parse('2026-06-18 08:00:00'));

    $this->postJson('/api/wa/webhook', [
        'sender' => ['phone' => '628987654321'],
        'message' => ['text' => 'Third message on new day']
    ])->assertStatus(200);

    $customer->refresh();
    $this->assertEquals(3, $customer->total_chats_received);
    $this->assertEquals(2, $customer->consultation_frequency); // Becomes 2!
    $this->assertEquals('2026-06-18 08:00:00', $customer->last_consultation_at->format('Y-m-d H:i:s'));

    Carbon::setTestNow(); // Reset time travel
});

test('it ignores webhook and skips saving if customer is not found', function () {
    // Post to the webhook using a new sender number
    $response = $this->postJson('/api/wa/webhook', [
        'sender' => [
            'phone' => '08999999999'
        ],
        'message' => [
            'text' => 'Hello, I am not a customer yet!'
        ]
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'ignored',
            'message' => 'Message received but sender is not registered as a customer.',
        ]);

    // Assert NO new customer was created
    $this->assertDatabaseMissing('customers', [
        'whatsapp_number' => '628999999999'
    ]);

    // Assert NO chat history record was saved
    $this->assertDatabaseMissing('chat_histories', [
        'whatsapp_number' => '628999999999'
    ]);
});

test('it returns 400 bad request if payload lacks sender.phone or message.text', function () {
    // Post without message text
    $response1 = $this->postJson('/api/wa/webhook', [
        'sender' => [
            'phone' => '08123456789'
        ]
    ]);
    $response1->assertStatus(400);

    // Post without sender phone
    $response2 = $this->postJson('/api/wa/webhook', [
        'message' => [
            'text' => 'Hello without sender phone'
        ]
    ]);
    $response2->assertStatus(400);
});
