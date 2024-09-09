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

            $table->string('title');
            $table->string('title_es')->nullable();
            $table->string('title_pt')->nullable();
            
            $table->string('short_description')->nullable();
            $table->string('short_description_es')->nullable();
            $table->string('short_description_pt')->nullable();

            $table->text('long_description')->nullable();
            $table->text('long_description_es')->nullable();
            $table->text('long_description_pt')->nullable();

            $table->string('thumbnail')->nullable();
            $table->string('thumbnail_es')->nullable();
            $table->string('thumbnail_pt')->nullable();

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
