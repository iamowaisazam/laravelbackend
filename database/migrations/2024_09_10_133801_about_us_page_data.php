<?php

use App\Models\Post;
use App\Models\Slider;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

use function PHPSTORM_META\map;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        

        // Banner

        $data = [
            "title" => 'Quiénes somos',
            "description" => 'El Centro Latinoamericano de Administración para el Desarrollo (CLAD) es un organismo público internacional de carácter intergubernamental, fundado en 1972 por los gobiernos de México, Perú y Venezuela. Nuestra sede se encuentra en Caracas, República Bolivariana de Venezuela, conforme a la “Ley Aprobatoria del Acuerdo de Sede entre el Gobierno de la República de Venezuela y el Centro Latinoamericano de Administración para el Desarrollo” (G.O. Nº 2.718 del 30 de diciembre de 1980).',
            "image" => 'uploads/about_banner.png',
        ];

        DB::table('settings')->insert([
            'name' => 'about_banner',
            'value_en' => json_encode($data),
            'value_es' => json_encode($data),
            'value_pt' => json_encode($data),
            'type' => 'text',
        ]);


         // Hero Section
            $data = "<p>“Impulsando una transformación </p><p>gubernamental colaborativa e inclusiva</p>";
            DB::table('settings')->insert([
                'name' => 'about_banner',
                'value_en' => $data,
                'value_es' => $data,
                'value_pt' => $data,
                'type' => 'text',
            ]);


            // About Creation Of Clad
            $data = [
                "title" => "Creación del CLAD",
                "description" => "<p>La creación del CLAD fue respaldada por la Asamblea General de las Naciones Unidas (Resolución 2845 XXVI) con el
                propósito de establecer una entidad regional enfocada en la modernización de las administraciones públicas, un factor
                estratégico para el desarrollo económico y social. Con 52 años de historia, nuestra organización se dedica a asesorar y
                guiar a los gobiernos en temas de gestión pública, desarrollando programas de cooperación internacional centrados
                en la reforma y modernización administrativa.</p> 
                <p>Nos destacamos como la única entidad especializada en la modernización de la gestión pública en la región, siendo un
                referente en la agenda de estos asuntos y promoviendo la integración interregional entre nuestros 24 países
                miembros de Latinoamérica, Europa y África</p> ",
            ];
            DB::table('settings')->insert([
                'name' => 'about_creation_of_clad',
                'value_en' => json_encode($data),
                'value_es' => json_encode($data),
                'value_pt' => json_encode($data),
                'type' => 'text',
            ]);


                // Missions
                $data = [
                    "title" => "Misión",
                    "image" => "uploads/about_mission.png",

                    "button_1_text" => "Acceda a nuestra planificación 2024-2026",
                    "button_1_icon" => "uploads/about_button_1_icon",
                    "button_2_text" => "Acesse nosso planejamento 2024-2026",
                    "button_2_icon" => "uploads/about_button_2_icon",
                    
                    "description" => "<p>Nuestra misión es conectar países, instituciones y profesionales, para fomentar la creación de redes, el análisis y
                    el intercambio de experiencias y conocimientos en áreas
                    clave como la reforma del Estado y la modernización de la
                    Administración Pública. Lo logramos a través de la
                    cooperación internacional para el desarrollo entre nuestros
                    países miembros, formación y capacitación del funcionariado,
                    la organización de eventos y reuniones internacionales
                    especializadas, la labor editorial y de investigación, y la
                    ejecución de proyectos de asistencia técnica.
                    </p>",
                ];

                DB::table('settings')->insert([
                    'name' => 'about_mission',
                    'value_en' => json_encode($data),
                    'value_es' => json_encode($data),
                    'value_pt' => json_encode($data),
                    'type' => 'text',
                ]);



                // About Contires
                $data = [
                "title" => "Países que conforman el CLAD",
                "image" => "uploads/about_map.png",

                "box1_text" => "23",
                "box1_color" => "#594EE6",
                "box1_number" => "Países miembros",

                "box2_text" => "01",
                "box2_color" => "#EC589F",
                "box2_number" => "Países observadores",

                "box3_text" => "49",
                "box3_color" => "#8AE6DE",
                "box3_number" => "Países aliados",

                "description" => "<p>El CLAD está compuesto por 24 países miembros de Latinoamérica, Europa y África, que unen esfuerzos y generan alianzas para mejorar el desarrollo y la sostenibilidad de las naciones en torno a la modernización de la gestión pública.</p>",];

                DB::table('settings')->insert([
                    'name' => 'about_countries',
                    'value_en' => json_encode($data),
                    'value_es' => json_encode($data),
                    'value_pt' => json_encode($data),
                    'type' => 'text',
                ]);


                // about_governence 
                $data = [
                    "title" => "Gobernanza",
                    "description" => "<p>Conoce cómo está estructurado el CLAD, para garantizar la dirección estratégica y la supervisión efectiva de sus actividades y programas.</p>",];
    
                    DB::table('settings')->insert([
                        'name' => 'about_governence',
                        'value_en' => json_encode($data),
                        'value_es' => json_encode($data),
                        'value_pt' => json_encode($data),
                        'type' => 'text',
                    ]);



                 // about_directors 
                 $data = [
                  "title" => "Nuestra Mesa Directiva",
                  "description" => "<p>Constituida por el Presidente, los Vicepresidentes, y el Secretario General. El Presidente, de propia iniciativa o a petición del Secretario General, somete a la decisión de la Mesa Directiva aquellos asuntos cuya importancia obliga a que sean resueltos antes de la reunión del Consejo Directivo</p>",
                  "heading" => "Miembros plenos",
                  "directors" => [
                        [
                            "image" => "uploads/about_director1.png",
                            "description" => "D . Esther Dweck, Ministra da Gestão e da Inovação em Serviços Públicos",
                            "country_name" => "Brasil",
                            "country_icon" => "upload/about_button_2_icon",
                            "title" => "Presidenta del Consejo Directivo"
                        ],
                  ]
                ];

                DB::table('settings')->insert([
                    'name' => 'about_directors',
                    'value_en' => json_encode($data),
                    'value_es' => json_encode($data),
                    'value_pt' => json_encode($data),
                    'type' => 'text',
                ]);

                
                 // about_team 
                 $data = [
                    "title" => "Nuestra Mesa Directiva",
                    "description" => "<p>Constituida por el Presidente, los Vicepresidentes, y el Secretario General. El Presidente, de propia iniciativa o a petición del Secretario General, somete a la decisión de la Mesa Directiva aquellos asuntos cuya importancia obliga a que sean resueltos antes de la reunión del Consejo Directivo</p>",
                    "heading" => "Miembros plenos",
                    "directors" => [
                          [
                              "image" => "uploads/about_director1.png",
                              "description" => "D . Esther Dweck, Ministra da Gestão e da Inovação em Serviços Públicos",
                              "country_name" => "Brasil",
                              "country_icon" => "upload/about_button_2_icon",
                              "title" => "Presidenta del Consejo Directivo"
                          ],
                    ]
                  ];
  
                  DB::table('settings')->insert([
                      'name' => 'about_directors',
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
        //
    }
};
