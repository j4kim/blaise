<?php

use App\Models\Client;
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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignIdFor(Client::class);
            $table->datetime('visit_date');
            $table->decimal('billed', 5, 2)->nullable();
            $table->decimal('rounding', 4, 2)->nullable();
            $table->decimal('tip', 4, 2)->nullable();
            $table->decimal('voucher_payment', 5, 2)->nullable();
            $table->decimal('cash_payment', 5, 2)->nullable();
            $table->decimal('twint_payment', 5, 2)->nullable();
            $table->decimal('card_payment', 5, 2)->nullable();
            $table->boolean('send_by_email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
