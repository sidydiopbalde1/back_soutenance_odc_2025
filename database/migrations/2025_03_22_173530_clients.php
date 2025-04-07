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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('msisdn')->unique()->comment('Numéro de téléphone');
            $table->decimal('solde', 10, 2)->default(0)->comment('solde du client');
            $table->string('email')->unique();
            $table->string('user_first_name');
            $table->string('user_last_name');
            $table->enum('sex', ['M', 'F']);
            $table->timestamp('registered_on')->useCurrent()->comment('Date d\'inscription');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
