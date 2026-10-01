<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');

            $table->string('order_code', 20)->unique();

            $table->unsignedInteger('user_id');

            $table->text('pickup_address');
            $table->text('customer_note')->nullable();

            $table->decimal('total_weight', 8, 2)->nullable();
            $table->decimal('total_price', 12, 2)->nullable();

            $table->dateTime('estimated_completed_at')->nullable();

            $table->enum('status', [
                'pending',
                'confirmed',
                'processing',
                'washing',
                'finishing',
                'ready',
                'completed',
                'cancelled',
            ])->default('pending');

            $table->dateTime('confirmed_at')->nullable();

            $table->unsignedInteger('confirmed_by')->nullable();

            $table->timestamps();

            // Relasi pelanggan
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            // Relasi admin yang mengonfirmasi
            $table->foreign('confirmed_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
