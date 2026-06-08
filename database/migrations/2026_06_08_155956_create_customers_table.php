<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name'); // Tipe data string lebih cocok untuk nama daripada bigint
            $table->string('whatsapp_number')->unique();
            $table->string('occupation')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->integer('total_chats_received')->default(0);
            $table->integer('consultation_frequency')->default(0);
            $table->timestamp('last_consultation_at')->nullable();
            $table->integer('web_visit_count')->default(0);
            $table->integer('transaction_count')->default(0);
            $table->decimal('total_transaction_value', 15, 2)->default(0); // Decimal cocok untuk nilai uang
            $table->string('last_product_interest')->nullable();
            $table->string('lead_score_status')->nullable();
            $table->integer('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
