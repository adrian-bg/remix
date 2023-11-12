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
        Schema::create('card_providers', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name')->unique();
            $table->timestamps();
        });

        DB::table('card_providers')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'Visa',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 2,
                    'name' => 'Mastercard',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_providers');
    }
};
