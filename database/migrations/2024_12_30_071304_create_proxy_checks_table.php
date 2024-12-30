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
        Schema::create('proxy_checks', function (Blueprint $table) {
            $table->id();
            $table->timestamp('started_at');
            $table->timestamp('finished_at')->nullable();
            $table->integer('total_proxies');
            $table->integer('working_proxies')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proxy_checks');
    }
};
