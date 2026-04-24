<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BakeryProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Bánh kem dâu tươi 16cm',
                'category' => 'Bánh sinh nhật',
                'brand' => 'Sweet Bakery Signature',
                'sku' => 'CAKE-001',
                'price' => 320000,
                'sale_price' => 289000,
                'quantity' => 20,
                'cake_type' => 'Bánh kem tươi',
                'size' => '16cm',
                'serving_size' => '6-8 người',
                'flavor' => 'Dâu tươi',
                'occasion' => 'Sinh nhật',
                'collection' => 'Fresh Berry',
                'ingredients' => 'Cốt vani, kem tươi, dâu tươi, sốt dâu nhà làm',
                'allergens' => 'Sữa, trứng, bột mì',
                'storage_instructions' => 'Bảo quản lạnh 2-4°C',
                'shelf_life' => 'Ngon nhất trong ngày',
                'is_customizable' => true,
                'custom_message' => 'Happy Birthday',
                'lead_time_hours' => 3,
                'is_featured' => true,
                'description' => 'Mẫu bánh sinh nhật bán chạy với vị dâu tươi nhẹ, kem mịn và dễ ăn cho nhiều lứa tuổi.',
            ],
            [
                'name' => 'Bánh mousse chanh dây mini',
                'category' => 'Bánh mousse',
                'brand' => 'Daily Fresh',
                'sku' => 'MOUSSE-001',
                'price' => 45000,
                'sale_price' => 39000,
                'quantity' => 50,
                'cake_type' => 'Mousse lạnh',
                'size' => 'Mini cup',
                'serving_size' => '1 phần',
                'flavor' => 'Chanh dây',
                'occasion' => 'Trà chiều',
                'collection' => 'Daily Fresh',
                'ingredients' => 'Mousse kem sữa, cốt bánh mềm, sốt chanh dây',
                'allergens' => 'Sữa, trứng',
                'storage_instructions' => 'Giữ lạnh liên tục',
                'shelf_life' => 'Dùng trong 24 giờ',
                'is_customizable' => false,
                'custom_message' => null,
                'lead_time_hours' => 1,
                'is_featured' => false,
                'description' => 'Bánh mousse mini vị chua ngọt hài hòa, phù hợp dùng nhanh trong ngày.',
            ],
            [
                'name' => 'Tiramisu cacao truyền thống',
                'category' => 'Bánh tiramisu',
                'brand' => 'Premium Collection',
                'sku' => 'TIRA-001',
                'price' => 280000,
                'sale_price' => null,
                'quantity' => 15,
                'cake_type' => 'Tiramisu',
                'size' => '14cm',
                'serving_size' => '5-6 người',
                'flavor' => 'Cacao - cà phê',
                'occasion' => 'Kỷ niệm',
                'collection' => 'Classic Italian',
                'ingredients' => 'Mascarpone, cacao, cốt bánh ladyfinger, cà phê',
                'allergens' => 'Sữa, trứng, gluten',
                'storage_instructions' => 'Bảo quản lạnh',
                'shelf_life' => 'Ngon nhất trong ngày',
                'is_customizable' => true,
                'custom_message' => 'Best Wishes',
                'lead_time_hours' => 4,
                'is_featured' => true,
                'description' => 'Mẫu tiramisu vị truyền thống cân bằng giữa độ đắng nhẹ của cacao và vị béo thơm của kem.',
            ],
            [
                'name' => 'Combo cupcake 6 vị',
                'category' => 'Cupcake',
                'brand' => 'Party Box',
                'sku' => 'CUP-001',
                'price' => 180000,
                'sale_price' => 159000,
                'quantity' => 30,
                'cake_type' => 'Cupcake',
                'size' => 'Hộp 6 cái',
                'serving_size' => '6 phần',
                'flavor' => 'Mix nhiều vị',
                'occasion' => 'Tiệc trà',
                'collection' => 'Party Box',
                'ingredients' => 'Cupcake vani và socola, kem topping, trái cây trang trí',
                'allergens' => 'Sữa, trứng, gluten',
                'storage_instructions' => 'Tránh nắng nóng trực tiếp',
                'shelf_life' => 'Dùng trong ngày',
                'is_customizable' => false,
                'custom_message' => null,
                'lead_time_hours' => 2,
                'is_featured' => false,
                'description' => 'Set cupcake phù hợp cho họp nhóm, sinh nhật nhỏ và tiệc trà văn phòng.',
            ],
        ];

        foreach ($products as $item) {
            $categoryId = DB::table('categories')->where('name', $item['category'])->value('id');
            $brandId = DB::table('brands')->where('name', $item['brand'])->value('id');
            if (!$categoryId || !$brandId) {
                continue;
            }

            DB::table('products')->updateOrInsert(
                ['sku' => $item['sku']],
                [
                    'brand_id' => $brandId,
                    'category_id' => $categoryId,
                    'name' => $item['name'],
                    'slug' => Str::slug($item['name']),
                    'thumbnail' => null,
                    'price' => $item['price'],
                    'sale_price' => $item['sale_price'],
                    'quantity' => $item['quantity'],
                    'description' => $item['description'],
                    'cake_type' => $item['cake_type'],
                    'size' => $item['size'],
                    'serving_size' => $item['serving_size'],
                    'flavor' => $item['flavor'],
                    'occasion' => $item['occasion'],
                    'collection' => $item['collection'],
                    'ingredients' => $item['ingredients'],
                    'allergens' => $item['allergens'],
                    'storage_instructions' => $item['storage_instructions'],
                    'shelf_life' => $item['shelf_life'],
                    'is_customizable' => $item['is_customizable'],
                    'custom_message' => $item['custom_message'],
                    'lead_time_hours' => $item['lead_time_hours'],
                    'is_featured' => $item['is_featured'],
                    'cpu' => $item['cake_type'],
                    'ram' => $item['size'],
                    'storage' => $item['serving_size'],
                    'vga' => $item['flavor'],
                    'screen' => $item['storage_instructions'],
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
