<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('service_type', ['cashin', 'rc', 'b2bmerpay', 'cashout', 'merchpay', 'p2p']);
            $table->foreignId('sender_msisdn_id')->constrained('clients')->onDelete('cascade');
            $table->decimal('transaction_amount', 12, 2);
            $table->decimal('commission_paid', 10, 2)->default(0);
            $table->timestamp('transfert_datetime');
            $table->enum('sender_user_type', ['channel', 'subscriber']);
            $table->boolean('rewarded')->default(false)->comment('Transaction rewarded');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
