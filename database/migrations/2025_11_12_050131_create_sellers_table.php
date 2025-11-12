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
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')
                ->unique()
                ->constrained('users')
                ->onDelete('cascade');

            $table->string('shop_name');
            $table->string('shop_slug')->unique();
            $table->text('shop_description')->nullable();
            $table->enum('verification_status', ['pending', 'approved', 'rejected'])
                ->default('pending');
            $table->timestamp('verified_at')->nullable();
            $table->boolean('is_active')->default(false);


            $table->timestamps();
            $table->softDeletes();
            $table->index('shop_slug');
            $table->index('verification_status');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
