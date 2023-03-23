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
        Schema::create('iami_orders', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable()->index();
            $table->string('order_number')->nullable()->index();
            $table->string('purchase_order_number')->nullable()->index();
            $table->date('order_date')->nullable();
            $table->time('order_time')->nullable();
            $table->string('delivery_cycle', 10)->nullable();
            $table->string('barcode_device')->nullable();
            $table->string('status')->default('open')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->longText('data')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iami_orders');
    }
};
