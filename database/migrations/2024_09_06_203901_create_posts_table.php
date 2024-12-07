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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->string('slug')->nullable();
            $table->integer('category_id')->nullable();

            $table->string('title_en')->nullable();
            $table->string('title_es')->nullable();
            $table->string('title_pt')->nullable();
            
            $table->text('short_description_en')->nullable();
            $table->text('short_description_es')->nullable();
            $table->text('short_description_pt')->nullable();

            $table->text('long_description_en')->nullable();
            $table->text('long_description_es')->nullable();
            $table->text('long_description_pt')->nullable();

            $table->string('thumbnail_en')->nullable();
            $table->string('thumbnail_es')->nullable();
            $table->string('thumbnail_pt')->nullable();

            $table->string('banner_en')->nullable();
            $table->string('banner_es')->nullable();
            $table->string('banner_pt')->nullable();

            $table->string('pdf_en')->nullable();
            $table->string('pdf_es')->nullable();
            $table->string('pdf_pt')->nullable();

            $table->string('creater_en')->nullable();
            $table->string('creater_es')->nullable();
            $table->string('creater_pt')->nullable();

            $table->string('author_en')->nullable();
            $table->string('author_es')->nullable();
            $table->string('author_pt')->nullable();

            $table->string('views_en')->nullable();
            $table->string('views_es')->nullable();
            $table->string('views_pt')->nullable();

            $table->string('like_en')->nullable();
            $table->string('like_es')->nullable();
            $table->string('like_pt')->nullable();

            $table->string('type')->nullable();
            $table->integer('is_featured')->nullable()->default(0);
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
        Schema::dropIfExists('posts');
    }
};