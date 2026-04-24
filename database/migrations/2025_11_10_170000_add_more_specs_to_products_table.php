<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ĐÂY LÀ TỆP MIGRATION TỔNG HỢP (đã bao gồm các lần sửa trước)

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            
            // --- 1. Thông số chung (cho Linh kiện, Gear...) ---
            $table->string('spec_type')->nullable()->after('screen'); // VD: DDR4, SSD, Switch cơ
            $table->string('spec_capacity')->nullable()->after('spec_type'); // VD: 8GB, 1TB
            $table->string('spec_speed')->nullable()->after('spec_capacity'); // VD: 3200MHz, 7000MB/s
            $table->string('spec_connection_type')->nullable()->after('spec_speed'); // VD: USB-C, Bluetooth

            // --- 2. Thông số Màn hình ---
            $table->string('spec_screen_size')->nullable()->after('spec_connection_type'); // VD: 24 inch
            $table->string('spec_refresh_rate')->nullable()->after('spec_screen_size'); // VD: 144Hz
            $table->string('spec_panel_type')->nullable()->after('spec_refresh_rate'); // VD: IPS, VA

            // --- 3. Thông số Gaming Gear (Chuột, Phím) ---
            $table->string('spec_dpi')->nullable()->after('spec_panel_type'); // VD: 16000 DPI
            $table->string('spec_switch_type')->nullable()->after('spec_dpi'); // VD: Red Switch

            // --- 4. (MỚI) Thông số Apple / Máy tính bảng ---
            $table->string('spec_chip')->nullable()->after('spec_switch_type'); // VD: Apple M2, Snapdragon 8
            $table->string('spec_storage_options')->nullable()->after('spec_chip'); // VD: 128GB, 256GB
            $table->string('spec_ram_options')->nullable()->after('spec_storage_options'); // VD: 8GB, 16GB
            $table->string('spec_screen_info')->nullable()->after('spec_ram_options'); // VD: 11 inch Liquid Retina

            // --- 5. (MỚI) Thông số Thiết bị văn phòng (Máy in...) ---
            $table->string('spec_function')->nullable()->after('spec_screen_info'); // VD: In, Scan, Copy
            $table->string('spec_print_speed')->nullable()->after('spec_function'); // VD: 20 trang/phút
            $table->string('spec_paper_size')->nullable()->after('spec_print_speed'); // VD: A4, A3

            // --- 6. (MỚI) Thông số Thiết bị mạng (Router...) ---
            $table->string('spec_wifi_standard')->nullable()->after('spec_paper_size'); // VD: Wi-Fi 6
            $table->string('spec_ports')->nullable()->after('spec_wifi_standard'); // VD: 4x LAN, 1x WAN
            $table->string('spec_antenna')->nullable()->after('spec_ports'); // VD: 4 ăng ten
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                // 1
                'spec_type',
                'spec_capacity',
                'spec_speed',
                'spec_connection_type',
                // 2
                'spec_screen_size',
                'spec_refresh_rate',
                'spec_panel_type',
                // 3
                'spec_dpi',
                'spec_switch_type',
                // 4 (MỚI)
                'spec_chip',
                'spec_storage_options',
                'spec_ram_options',
                'spec_screen_info',
                // 5 (MỚI)
                'spec_function',
                'spec_print_speed',
                'spec_paper_size',
                // 6 (MỚI)
                'spec_wifi_standard',
                'spec_ports',
                'spec_antenna',
            ]);
        });
    }
};