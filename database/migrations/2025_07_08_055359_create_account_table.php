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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_holder_name');
            $table->unsignedBigInteger('user_id');
            $table->string('account_number')->unique();
            $table->decimal('balance', 15, 2)->default(0);
            $table->decimal('minimum_balance', 15, 2)->default(0);
            $table->tinyInteger('status')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'is_active']);
            $table->index('account_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('accounts');
    }
};