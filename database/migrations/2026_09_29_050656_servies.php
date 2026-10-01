<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servies', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('category_id');

            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->enum('unit', ['kg', 'pcs', 'pair']);
            $table->integer('estimated_hours');
            $table->enum('service_type', ['regular', 'express']);
            $table->enum('status', ['active', 'inactive'])
                ->default('active');

            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('service_categories')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servies');
    }
};
