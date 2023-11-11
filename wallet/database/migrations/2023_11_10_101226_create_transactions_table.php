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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')
                ->references('id')
                ->on('accounts');
            $table->integer('transaction_type_id')->nullable(false);
            $table->foreign('transaction_type_id')
                ->references('id')
                ->on('transaction_types');
            $table->integer('transaction_status_id')->nullable(false);
            $table->foreign('transaction_status_id')
                ->references('id')
                ->on('transaction_statuses');
            $table->float('balance', 12,2)
                ->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
