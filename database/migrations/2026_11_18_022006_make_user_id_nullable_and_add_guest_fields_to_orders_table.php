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
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable()->change();

            if (! Schema::hasColumn('orders', 'customer_name')) {
                $table->string('customer_name', 100)->nullable()->after('user_id');
            }

            if (! Schema::hasColumn('orders', 'customer_phone')) {
                $table->string('customer_phone', 30)->nullable()->after('customer_name');
            }
        });

        Schema::table('order_status_histories', function (Blueprint $table) {
            $table->unsignedInteger('changed_by')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('order_status_histories', function (Blueprint $table) {
            $table->unsignedInteger('changed_by')->nullable(false)->change();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['customer_name', 'customer_phone']);
            $table->unsignedInteger('user_id')->nullable(false)->change();
        });
    }
};
