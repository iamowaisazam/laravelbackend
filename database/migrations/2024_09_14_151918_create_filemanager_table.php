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
        Schema::create('filemanagers', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('orignal_name')->nullable();
            $table->string('name')->nullable();
            $table->string('extension')->nullable();
            $table->string('type')->nullable();
            $table->string('size')->nullable();
            $table->string('path')->nullable();
            $table->string('link')->nullable();
            $table->string('created_by')->nullable();
            $table->string('access_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filemanager');
    }
};
