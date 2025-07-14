<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Only add columns that don't already exist
            if (!Schema::hasColumn('payments', 'reservation_id')) {
                $table->unsignedBigInteger('reservation_id')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('payments', 'plot_id')) {
                $table->unsignedBigInteger('plot_id')->nullable()->after('reservation_id');
            }
            if (!Schema::hasColumn('payments', 'transaction_id')) {
                $table->string('transaction_id')->nullable()->after('status');
            }
            if (!Schema::hasColumn('payments', 'provider')) {
                $table->string('provider')->nullable()->after('transaction_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['reservation_id', 'plot_id', 'transaction_id', 'provider']);
        });
    }
}; 