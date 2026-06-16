<?php

use App\Models\User;
use App\Models\Customer;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->customer = Customer::create([
        'full_name' => 'Jane Doe',
        'whatsapp_number' => '08123456789',
        'occupation' => 'Designer',
        'date_of_birth' => '1995-12-12',
        'is_active' => 1,
        'total_chats_received' => 5,
        'consultation_frequency' => 2,
        'web_visit_count' => 10,
        'transaction_count' => 1,
        'total_transaction_value' => 150000.00,
        'last_product_interest' => 'Kamera Indoor',
        'lead_score_status' => 'Warm',
        'payment_status' => 'Belum'
    ]);
});

test('customer edit page can be rendered for authenticated users and contains analytics fields', function () {
    $response = $this
        ->actingAs($this->user)
        ->get(route('customers.edit', $this->customer->id));

    $response->assertOk();
    $response->assertSee('Advanced Updated');
    $response->assertSee('total_chats_received');
    $response->assertSee('consultation_frequency');
    $response->assertSee('web_visit_count');
    $response->assertSee('transaction_count');
    $response->assertSee('total_transaction_value');
    $response->assertSee('last_product_interest');
    $response->assertSee('lead_score_status');
    $response->assertSee('payment_status');
});

test('authenticated user can update customer analytics fields successfully', function () {
    // Disable CSRF verification specifically for this test
    $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);

    $response = $this
        ->actingAs($this->user)
        ->put(route('customers.update', $this->customer->id), [
            'full_name' => 'Jane Doe Updated',
            'whatsapp_number' => '08123456789',
            'occupation' => 'Product Manager',
            'date_of_birth' => '1995-12-10',
            'is_active' => 1,
            'total_chats_received' => 25,
            'consultation_frequency' => 12,
            'web_visit_count' => 88,
            'transaction_count' => 5,
            'total_transaction_value' => 1250000.50,
            'last_product_interest' => 'CCTV Outdoor PTZ',
            'lead_score_status' => 'Hot',
            'payment_status' => 'Lunas'
        ]);

    $response->assertRedirect(route('customers.index'));
    
    $this->customer->refresh();

    $this->assertEquals('Jane Doe Updated', $this->customer->full_name);
    $this->assertEquals('628123456789', $this->customer->whatsapp_number);
    $this->assertEquals('Product Manager', $this->customer->occupation);
    $this->assertEquals('1995-12-10', $this->customer->date_of_birth);
    $this->assertEquals(25, $this->customer->total_chats_received);
    $this->assertEquals(12, $this->customer->consultation_frequency);
    $this->assertEquals(88, $this->customer->web_visit_count);
    $this->assertEquals(5, $this->customer->transaction_count);
    $this->assertEquals(1250000.50, $this->customer->total_transaction_value);
    $this->assertEquals('CCTV Outdoor PTZ', $this->customer->last_product_interest);
    $this->assertEquals('Hot', $this->customer->lead_score_status);
    $this->assertEquals('Lunas', $this->customer->payment_status);
});

test('updating customer with invalid analytics validation values fails', function () {
    // Disable CSRF verification specifically for this test
    $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);

    $response = $this
        ->actingAs($this->user)
        ->put(route('customers.update', $this->customer->id), [
            'full_name' => 'Jane Doe Updated',
            'whatsapp_number' => '08123456789',
            'is_active' => 1,
            'total_chats_received' => -1,
            'consultation_frequency' => 'not-an-integer',
            'web_visit_count' => -5,
            'transaction_count' => -2,
            'total_transaction_value' => -100.50,
            'last_product_interest' => str_repeat('a', 256),
            'lead_score_status' => 'InvalidStatus',
            'payment_status' => 'Pending'
        ]);

    $response->assertSessionHasErrors([
        'total_chats_received',
        'consultation_frequency',
        'web_visit_count',
        'transaction_count',
        'total_transaction_value',
        'last_product_interest',
        'lead_score_status',
        'payment_status'
    ]);
});
