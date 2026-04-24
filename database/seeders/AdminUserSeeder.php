<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Kiểm tra xem admin đã tồn tại chưa để tránh trùng lặp
        if (!User::where('email', 'admin@gmail.com')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456'), // Mật khẩu là 123456
                'phone' => '0999999999',
                'address' => 'Hà Nội',
                'role' => 1, // QUAN TRỌNG: role = 1 là Admin
            ]);
        }
    }
}