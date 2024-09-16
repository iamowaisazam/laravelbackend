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

            $table->string('title_en')->nullable();
            $table->string('title_es')->nullable();
            $table->string('title_pt')->nullable();

            $table->string('link_en')->nullable();
            $table->string('link_es')->nullable();
            $table->string('link_pt')->nullable();

            $table->string('short_description_en')->nullable();
            $table->string('short_description_es')->nullable();
            $table->string('short_description_pt')->nullable();

            $table->string('thumbnail_en')->nullable();
            $table->string('thumbnail_es')->nullable();
            $table->string('thumbnail_pt')->nullable();

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
