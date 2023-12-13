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
        Schema::create('seller_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller');
            $table->unsignedBigInteger('permission');
            $table->timestamps();

            $table->foreign('seller')->references('id')->on('sellers')->onDelete('cascade');
            $table->foreign('permission')->references('id')->on('permissions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_permissions');
    }
};
