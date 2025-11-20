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
        Schema::table('products', function (Blueprint $table) {
            $table->string('short_description')->nullable()->after('name');
            $table->longText('full_description')->nullable()->after('short_description');
            $table->json('specs')->nullable()->after('full_description');
            $table->string('category')->nullable()->after('specs');
            $table->string('brand')->nullable()->after('category');
            $table->string('model_no')->nullable()->after('brand');
            $table->string('warranty')->nullable()->after('model_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'short_description',
                'full_description',
                'specs',
                'category',
                'brand',
                'model_no',
                'warranty'
            ]);
        });
    }
};
