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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->foreignId('ticket_id')->constrained('tickets', 'ticket_id');
            $table->foreignId('tenant_id')->constrained('tenants', 'tenant_id');
            $table->foreignId('buyer_id')->constrained('clients', 'client_id');
            $table->float('price');
            $table->date('transaction_date');
            $table->enum('status', ['paid', 'pending', 'canceled']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
