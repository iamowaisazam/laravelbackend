<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('value_en')->nullable();
            $table->text('value_es')->nullable();
            $table->text('value_pt')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });


        DB::table('settings')->insert([
            'name' => 'home_about_title',
            'value_en' => 'Sobre el CLAD',
            'value_es' => 'Sobre el CLAD',
            'value_pt' => 'Sobre el CLAD',
            'type' => 'text',
        ]);

        DB::table('settings')->insert([
            'name' => 'home_about_image',
            'value_en' => 'image',
            'value_es' => 'image',
            'value_pt' => 'image',
            'type' => 'text',
        ]);

        DB::table('settings')->insert([
            'name' => 'home_about_description',
            'value_en' => '<p>El Centro Latinoamericano de Administración para el Desarrollo (CLAD) es un organismo público internacional de carácter intergubernamental, fundado en 1972 por los gobiernos de México, Perú y Venezuela.</p>',
            'value_es' => '<p>El Centro Latinoamericano de Administración para el Desarrollo (CLAD) es un organismo público internacional de carácter intergubernamental, fundado en 1972 por los gobiernos de México, Perú y Venezuela.</p>',
            'value_pt' => '<p>El Centro Latinoamericano de Administración para el Desarrollo (CLAD) es un organismo público internacional de carácter intergubernamental, fundado en 1972 por los gobiernos de México, Perú y Venezuela.</p>',
            'type' => 'text',
        ]);


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
