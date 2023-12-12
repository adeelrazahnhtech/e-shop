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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category');
            $table->unsignedBigInteger('sub_admin');
            $table->unsignedBigInteger('seller');
            $table->string('title');
            $table->text('description')->nullable();
            $table->double('price');
            $table->integer('track_qty')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
            
            $table->foreign('sub_admin')->references('id')->on('sub_admins')->onDelete('cascade');
            $table->foreign('seller')->references('id')->on('sellers')->onDelete('cascade');
            $table->foreign('category')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
