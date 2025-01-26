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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string("first_name")->nullable();
            $table->string("last_name")->nullable();
            $table->string("tel_1")->nullable();
            $table->string("tel_2")->nullable();
            $table->string("tel_3")->nullable();
            $table->integer("npa")->nullable();
            $table->string("location")->nullable();
            $table->tinyInteger("gender")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
