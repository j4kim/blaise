<?php

use App\Models\Article;
use App\Models\Service;
use App\Models\Visit;
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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Visit::class);
            $table->foreignIdFor(Service::class)->nullable();
            $table->foreignIdFor(Article::class)->nullable();
            $table->decimal('base_price', 5, 2)->nullable();
            $table->decimal('price_charged', 5, 2)->nullable();
            $table->integer('quantity')->default(1);
            $table->string('type')->nullable();
            $table->string('label')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
