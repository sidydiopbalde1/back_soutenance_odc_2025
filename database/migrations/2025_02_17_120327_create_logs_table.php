<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('action')->nullable();  
            $table->text('message'); 
            $table->string('user_name')->nullable();  
            $table->string('ip_address')->nullable();  
            $table->string('status')->nullable();  
            $table->json('context')->nullable(); 
            $table->timestamps(); 
            $table->softDeletes(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
