<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BakeryCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Bánh sinh nhật',
            'Bánh mousse',
            'Bánh tiramisu',
            'Cheesecake',
            'Bánh mì ngọt',
            'Cookie & Biscuit',
            'Cupcake',
            'Combo tiệc trà',
        ];

        foreach ($categories as $name) {
            DB::table('categories')->updateOrInsert(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'slug' => Str::slug($name), 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
