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
        Schema::table('Product', function (Blueprint $table) {
            $table->string('image_detail_1_url', 255)->nullable()->after('image_hover_url');
            $table->string('image_detail_2_url', 255)->nullable()->after('image_detail_1_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Product', function (Blueprint $table) {
            $table->dropColumn(['image_detail_1_url', 'image_detail_2_url']);
        });
    }
};
