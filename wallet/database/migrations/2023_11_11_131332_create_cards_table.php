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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->integer('card_type_id')->nullable(false);
            $table->foreign('card_type_id')
                ->references('id')
                ->on('card_types');
            $table->integer('card_provider_id')->nullable(false);
            $table->foreign('card_provider_id')
                ->references('id')
                ->on('card_providers');
            $table->string('names', 100);
            $table->string('number', 50)->unique();;
            $table->string('cvv', 10);
            $table->string('expire_at', 50);
            $table->softDeletes( 'deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
