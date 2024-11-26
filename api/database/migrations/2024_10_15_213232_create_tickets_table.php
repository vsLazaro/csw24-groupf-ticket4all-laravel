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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id('ticket_id');
            $table->foreignId('event_id')->constrained('events', 'event_id');
            $table->foreignId('seller_id')->constrained('clients', 'client_id');
            $table->foreignId('tenant_id')->constrained('tenants', 'tenant_id');
            $table->float('original_price');
            $table->string('verification_code',255);
            $table->enum('status', ['sold', 'available', 'reserved']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
