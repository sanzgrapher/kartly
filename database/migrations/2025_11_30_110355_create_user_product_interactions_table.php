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
        Schema::create('user_product_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('session_id')->nullable(); // For guest users
            $table->enum('interaction_type', ['view', 'cart', 'purchase']);
            $table->tinyInteger('rating');
            $table->integer('interaction_count')->default(1); // Track multiple interactions
            $table->timestamps();

            // Indexes for performance
            $table->index('user_id');
            $table->index('product_id');
            $table->index('session_id');
            $table->index(['user_id', 'product_id']);
            $table->index('interaction_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_product_interactions');
    }
};
