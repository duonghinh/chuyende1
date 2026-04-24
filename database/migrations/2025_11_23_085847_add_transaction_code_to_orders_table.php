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
            
            // 1. Thêm cột payment_method (nếu chưa có)
            if (!Schema::hasColumn('orders', 'payment_method')) {
                // Nếu có cột total_amount thì thêm sau nó, không thì thêm vào cuối
                if (Schema::hasColumn('orders', 'total_amount')) {
                    $table->string('payment_method')->default('COD')->after('total_amount');
                } else {
                    $table->string('payment_method')->default('COD');
                }
            }

            // 2. Thêm cột payment_status (nếu chưa có)
            if (!Schema::hasColumn('orders', 'payment_status')) {
                if (Schema::hasColumn('orders', 'payment_method')) {
                    $table->string('payment_status')->default('Unpaid')->after('payment_method');
                } else {
                    $table->string('payment_status')->default('Unpaid');
                }
            }

            // 3. Thêm cột transaction_code (nếu chưa có)
            if (!Schema::hasColumn('orders', 'transaction_code')) {
                if (Schema::hasColumn('orders', 'payment_status')) {
                    $table->string('transaction_code')->nullable()->after('payment_status');
                } else {
                    $table->string('transaction_code')->nullable();
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Xóa các cột nếu tồn tại
            if (Schema::hasColumn('orders', 'transaction_code')) {
                $table->dropColumn('transaction_code');
            }
            if (Schema::hasColumn('orders', 'payment_status')) {
                $table->dropColumn('payment_status');
            }
            if (Schema::hasColumn('orders', 'payment_method')) {
                $table->dropColumn('payment_method');
            }
        });
    }
};