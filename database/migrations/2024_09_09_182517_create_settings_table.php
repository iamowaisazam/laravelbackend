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

        // Slider ________________________________________________________

        $data  = [
            [
                'title' => 'Impulsando una transformación gubernamental colaborativa e inclusiva',
            ],
            [
                'title' => 'Impulsando una transformación gubernamental colaborativa e inclusiva',
            ],
            [
                'title' => 'Impulsando una transformación gubernamental colaborativa e inclusiva',
            ],
            [
                'title' => 'Impulsando una transformación gubernamental colaborativa e inclusiva'
            ]
        ];

        $data = collect($data)->map(function ($item) {
            $item['image'] = 'uploads/slide.png';
            $item['link'] = 'link';
            $item['button'] = 'view';
            return $item;
        })->toArray();

        
        DB::table('settings')->insert([
            'name' => 'home_slider',
            'value_en' => json_encode($data),
            'value_es' => json_encode($data),
            'value_pt' => json_encode($data),
            'type' => 'text',
        ]);






        // Home About ________________________________________________________

        $description = "<p>El Centro Latinoamericano de Administración para el Desarrollo (CLAD) es un organismo público internacional de carácter intergubernamental, fundado en 1972 por los gobiernos de México, Perú y Venezuela.</p>
        <p>El Centro Latinoamericano de Administración para el Desarrollo (CLAD) es un organismo público internacional de carácter intergubernamental, fundado en 1972 por los gobiernos de México, Perú y Venezuela.</p>
        <p>Nuestra misión es conectar países, instituciones y profesionales de la administración pública, facilitando el intercambio de conocimientos, la creación de redes y la implementación de mejores prácticas en áreas clave como el cambio climático, la gobernanza y la inclusión</p>";

        $data = [
            'title' => 'Sobre el CLAD',
            'image' => 'uploads/about.png',
            'description' => $description,
        ];


        DB::table('settings')->insert([
            'name' => 'home_about',
            'value_en' => json_encode($data),
            'value_es' => json_encode($data),
            'value_pt' => json_encode($data),
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
