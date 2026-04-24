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
    Schema::create('order_details', function (Blueprint $table) {
        $table->id();
        $table->foreignId('order_id')->constrained()->onDelete('cascade');
        // Nếu sản phẩm bị xóa khỏi hệ thống, giữ lại chi tiết đơn hàng nhưng product_id = null
        $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');

        $table->string('product_name'); // Lưu cứng tên SP tại thời điểm mua
        $table->integer('quantity');
        $table->decimal('price', 15, 2); // Lưu cứng giá SP tại thời điểm mua

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
