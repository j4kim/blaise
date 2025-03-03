<?php

use App\Models\Brand;
use App\Models\Line;
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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignIdFor(Brand::class)->nullable();
            $table->foreignIdFor(Line::class)->nullable();
            $table->string('barcode')->nullable();
            $table->string('label')->nullable();
            $table->decimal('retail_price', 5, 2)->nullable();
            $table->decimal('catalog_price', 5, 2)->nullable();
            $table->integer('sort_order')->nullable();
            $table->integer('stock')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
