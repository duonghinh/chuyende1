<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_users_table.php

public function up(): void
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('phone', 20)->nullable();
        $table->string('address')->nullable();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->tinyInteger('role')->default(0)->comment('0: Customer, 1: Admin');
        $table->rememberToken();
        $table->timestamps();
    });

    // ... các phần khác giữ nguyên (password_reset_tokens, sessions)
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
