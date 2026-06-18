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
    Schema::create('sales_targets', function (Blueprint $table) {
        $table->id();

        $table->foreignId('sales_id')
            ->constrained('users')
            ->cascadeOnDelete();

        $table->integer('month');
        $table->integer('year');

        $table->decimal('target_amount', 15, 2)->default(0);

        $table->timestamps();

        $table->unique(['sales_id', 'month', 'year']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_targets');
    }
};
