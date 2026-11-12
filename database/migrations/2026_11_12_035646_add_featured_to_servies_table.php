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
        Schema::table('servies', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false)->after('status');
            $table->unsignedInteger('featured_order')->nullable()->after('is_featured');
            $table->index(['status', 'is_featured', 'featured_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('servies', function (Blueprint $table) {
            $table->dropIndex(['status', 'is_featured', 'featured_order']);
            $table->dropColumn(['is_featured', 'featured_order']);
        });
    }
};
