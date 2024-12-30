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
        Schema::create('proxies', function (Blueprint $table) {
            $table->id();
            $table->string('ip');
            $table->integer('port');
            $table->string('type')->nullable(); // http/socks
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('status')->default('unchecked'); // unchecked, working, not working
            $table->float('speed')->nullable(); // Скорость отклика
            $table->string('external_ip')->nullable(); // внешний ip
            $table->unsignedBigInteger('check_id'); // Связь с проверкой
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proxies');
    }
};
