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
        Schema::create('iami_order_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('iami_orders');

            $table->string('id_abas')->nullable()->index();
            $table->string('part_number')->nullable()->index();
            $table->string('part_name')->nullable();
            $table->integer('order_qty')->nullable();
            $table->integer('total_kanban')->nullable();
            $table->integer('kanban_qty')->nullable();
            $table->string('lp')->nullable();
            $table->string('status')->nullable()->default('open');
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
        Schema::dropIfExists('iami_order_lists');
    }
};
