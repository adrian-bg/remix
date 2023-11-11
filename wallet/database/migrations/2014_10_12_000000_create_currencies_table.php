<?php

use Illuminate\Support\Facades\{
    DB,
    Schema
};
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('name')->unique();
            $table->string('code')->unique();
            $table->timestamps();
        });

        DB::table('currencies')->insert(
            [
                [
                    'name' => 'Euro',
                    'code' => 'EUR',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'US Dollar',
                    'code' => 'USD',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Lev',
                    'code' => 'BGN',
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
        Schema::dropIfExists('currencies');
    }
};
