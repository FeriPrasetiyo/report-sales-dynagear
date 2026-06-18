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
    Schema::create('sales_reports', function (Blueprint $table) {
        $table->id();

        $table->foreignId('sales_id')
            ->constrained('users')
            ->cascadeOnDelete();

        $table->date('tanggal')->nullable();

        $table->string('no_sq')->nullable();
        $table->string('no_po')->nullable();

        $table->string('customer_name');
        $table->text('description')->nullable();

        $table->integer('qty')->default(1);
        $table->decimal('price_unit', 15, 2)->default(0);
        $table->decimal('total', 15, 2)->default(0);

        $table->enum('status', [
            'pending',
            'deal',
            'no_deal'
        ])->default('pending');

        $table->text('sales_comment')->nullable();

        $table->date('next_followup_date')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_reports');
    }
};
