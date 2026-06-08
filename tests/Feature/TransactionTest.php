<?php

use App\Models\User;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;

beforeEach(function () {
    $this->user = User::factory()->create();
    
    $this->customer = Customer::create([
        'full_name' => 'John Doe',
        'whatsapp_number' => '08123456789',
        'is_active' => 1
    ]);

    $this->category = Category::create([
        'name' => 'CCTV Indoor',
        'slug' => 'cctv-indoor',
        'color' => '#ff0000'
    ]);

    $this->product = Product::create([
        'name' => 'Hikvision 2MP',
        'slug' => 'hikvision-2mp',
        'category_id' => $this->category->id,
        'image' => 'products/test.png',
        'merk' => 'Hikvision',
        'unit' => 'Unit',
        'price' => 300000,
        'is_active' => 1
    ]);
});

test('transactions index page can be rendered for authenticated users', function () {
    $response = $this
        ->actingAs($this->user)
        ->get(route('transactions.index'));

    $response->assertOk();
});

test('transactions create page can be rendered for authenticated users', function () {
    $response = $this
        ->actingAs($this->user)
        ->get(route('transactions.create'));

    $response->assertOk();
});

test('authenticated user can store a new transaction', function () {
    $response = $this
        ->actingAs($this->user)
        ->post(route('transactions.store'), [
            'customer_id' => $this->customer->id,
            'payment_status' => 'paid',
            'product_id' => [$this->product->id],
            'quantity' => [2]
        ]);

    $response->assertRedirect(route('transactions.index'));
    
    $this->assertDatabaseHas('transactions', [
        'customer_id' => $this->customer->id,
        'payment_status' => 'paid',
        'grand_total' => 600000 // 300000 * 2
    ]);

    $transaction = Transaction::first();

    $this->assertDatabaseHas('transaction_details', [
        'transaction_id' => $transaction->id,
        'product_id' => $this->product->id,
        'quantity' => 2,
        'sub_total' => 600000
    ]);
});

test('storing transaction fails with invalid data', function () {
    $response = $this
        ->actingAs($this->user)
        ->post(route('transactions.store'), [
            'customer_id' => 9999, // Non-existent customer
            'payment_status' => 'invalid-status',
            'product_id' => [],
            'quantity' => []
        ]);

    $response->assertSessionHasErrors(['customer_id', 'payment_status', 'product_id', 'quantity']);
});
