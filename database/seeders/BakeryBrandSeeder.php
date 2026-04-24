<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BakeryBrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = ['Sweet Bakery Signature', 'Premium Collection', 'Daily Fresh', 'Party Box'];

        foreach ($brands as $name) {
            DB::table('brands')->updateOrInsert(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'slug' => Str::slug($name), 'logo' => null, 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
