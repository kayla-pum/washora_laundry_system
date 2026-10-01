<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('order_id');
            $table->enum('item_type', ['service', 'package'])->default('service');
            $table->unsignedInteger('service_id')->nullable();
            $table->unsignedInteger('package_id')->nullable();
            $table->string('item_name', 150);
            $table->string('unit', 30)->default('kg');
            $table->decimal('quantity', 8, 2)->default(1);
            $table->decimal('unit_price', 12, 2)->default(0);
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->text('notes')->nullable();

            $table->timestamps();

            // Relasi ke tabel orders
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            // Relasi ke tabel servies
            $table->foreign('service_id')
                ->references('id')
                ->on('servies')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            // Relasi ke tabel packages
            $table->foreign('package_id')
                ->references('id')
                ->on('packages')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
