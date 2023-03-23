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
        Schema::create('iami_labels', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_list_id')->constrained('iami_order_lists');
            $table->foreignId('order_id')->constrained('iami_orders');
            $table->string('kanban_number')->nullable()->index();
            $table->string('msi_label_number')->nullable()->index();
            $table->dateTime('kanban_scan_at')->nullable();
            $table->string('kanban_scan_by')->nullable();
            $table->dateTime('msi_label_scan_at')->nullable();
            $table->string('msi_label_scan_by')->nullable();
            $table->integer('serie_number')->nullable();
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
        Schema::dropIfExists('iami_labels');
    }
};
