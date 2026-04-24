<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::saving(function ($product) {
            $product->slug = Str::slug($product->name, '-');
        });
    }

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'thumbnail',
        'description',
        'price',
        'sale_price',
        'quantity',
        'status',
        'category_id',
        'brand_id',
        'cake_type',
        'size',
        'serving_size',
        'flavor',
        'occasion',
        'collection',
        'ingredients',
        'allergens',
        'storage_instructions',
        'shelf_life',
        'is_customizable',
        'custom_message',
        'lead_time_hours',
        'is_featured',
        'cpu',
        'ram',
        'storage',
        'vga',
        'screen',
        'spec_type',
        'spec_capacity',
        'spec_speed',
        'spec_connection_type',
        'spec_screen_size',
        'spec_refresh_rate',
        'spec_panel_type',
        'spec_dpi',
        'spec_switch_type',
        'spec_chip',
        'spec_storage_options',
        'spec_ram_options',
        'spec_screen_info',
        'spec_function',
        'spec_print_speed',
        'spec_paper_size',
        'spec_wifi_standard',
        'spec_ports',
        'spec_antenna',
    ];

    protected $casts = [
        'is_customizable' => 'boolean',
        'is_featured' => 'boolean',
    ];

    protected $appends = [
        'display_cake_type',
        'display_size',
        'display_serving_size',
        'display_flavor',
        'display_storage_instructions',
        'display_shelf_life',
    ];

    public function getDisplayCakeTypeAttribute(): ?string
    {
        return $this->cake_type ?: $this->cpu;
    }

    public function getDisplaySizeAttribute(): ?string
    {
        return $this->size ?: $this->ram;
    }

    public function getDisplayServingSizeAttribute(): ?string
    {
        return $this->serving_size ?: $this->storage;
    }

    public function getDisplayFlavorAttribute(): ?string
    {
        return $this->flavor ?: $this->vga;
    }

    public function getDisplayStorageInstructionsAttribute(): ?string
    {
        return $this->storage_instructions ?: $this->screen;
    }

    public function getDisplayShelfLifeAttribute(): ?string
    {
        return $this->shelf_life ?: $this->screen;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
