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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('link')->nullable();
            $table->string('short_description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('lang');
            $table->integer('sorting')->nullable()->default(0);
            $table->integer('status')->nullable()->default(1);
            $table->integer('created_by')->nullable()->default(null);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
