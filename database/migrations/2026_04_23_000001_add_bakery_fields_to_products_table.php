<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('cake_type')->nullable()->after('description');
            $table->string('size')->nullable()->after('cake_type');
            $table->string('serving_size')->nullable()->after('size');
            $table->string('flavor')->nullable()->after('serving_size');
            $table->string('occasion')->nullable()->after('flavor');
            $table->string('collection')->nullable()->after('occasion');
            $table->text('ingredients')->nullable()->after('collection');
            $table->string('allergens')->nullable()->after('ingredients');
            $table->string('storage_instructions')->nullable()->after('allergens');
            $table->string('shelf_life')->nullable()->after('storage_instructions');
            $table->boolean('is_customizable')->default(false)->after('shelf_life');
            $table->string('custom_message')->nullable()->after('is_customizable');
            $table->unsignedInteger('lead_time_hours')->default(2)->after('custom_message');
            $table->boolean('is_featured')->default(false)->after('lead_time_hours');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
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
            ]);
        });
    }
};
