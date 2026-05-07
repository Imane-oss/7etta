<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('Product', function (Blueprint $table) {
            $table->string('slug', 100)->nullable()->unique()->after('name_product');
            $table->text('description')->nullable()->after('slug');
        });

        // Generate slugs for existing products
        $products = DB::table('Product')->get();
        foreach ($products as $product) {
            DB::table('Product')
                ->where('product_id', $product->product_id)
                ->update([
                    'slug' => Str::slug($product->name_product) . '-' . $product->product_id,
                ]);
        }
    }

    public function down(): void
    {
        Schema::table('Product', function (Blueprint $table) {
            $table->dropColumn(['slug', 'description']);
        });
    }
};
