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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        // Nếu user bị xóa, đơn hàng vẫn giữ nhưng user_id set về null
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

        $table->string('customer_name');
        $table->string('customer_phone', 20);
        $table->string('customer_email')->nullable();
        $table->text('shipping_address');
        $table->text('note')->nullable(); // Ghi chú đơn hàng

        $table->decimal('total_amount', 15, 2); // Tổng tiền
        $table->string('payment_method')->default('COD'); // Phương thức thanh toán
        // 0: Chờ xác nhận, 1: Đang giao, 2: Đã giao, 3: Đã hủy
        $table->tinyInteger('status')->default(0);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
