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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        // Khóa ngoại
        $table->foreignId('brand_id')->constrained()->onDelete('cascade'); // Xóa brand thì xóa luôn sp
        $table->foreignId('category_id')->constrained()->onDelete('cascade');

        $table->string('name');
        $table->string('slug')->unique();
        $table->string('sku')->unique()->comment('Mã sản phẩm');
        $table->string('thumbnail')->nullable(); // Ảnh đại diện
        $table->decimal('price', 15, 2); // Giá niêm yết (tối đa 15 số, 2 số thập phân)
        $table->decimal('sale_price', 15, 2)->nullable(); // Giá khuyến mãi
        $table->integer('quantity')->default(0); // Tồn kho
        $table->text('description')->nullable();

        // Các thông số kỹ thuật cơ bản để lọc
        $table->string('cpu')->nullable();
        $table->string('ram')->nullable();
        $table->string('storage')->nullable();
        $table->string('vga')->nullable();
        $table->string('screen')->nullable();

        $table->tinyInteger('status')->default(1)->comment('0: Ẩn, 1: Hiển thị');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
