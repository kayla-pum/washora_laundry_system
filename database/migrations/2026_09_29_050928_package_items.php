<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_items', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('package_id');
            $table->unsignedInteger('service_id');

            $table->timestamps();

            $table->foreign('package_id')
                ->references('id')
                ->on('packages')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('service_id')
                ->references('id')
                ->on('servies')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_items');
    }
};
