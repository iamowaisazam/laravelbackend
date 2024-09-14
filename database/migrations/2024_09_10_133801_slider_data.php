<?php

use App\Models\Slider;
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

        //
        $data  = [
            [
                'title' => 'Title English',
                'title_es' => 'Title Es',
                'title_pt' => 'Title Pt',
                'link' => 'link English',
                'link_es' => 'link ES',
                'link_pt' => 'link PT',
                'short_description' => 'Short Description English',
                'short_description_es' => 'Short Description Espanish',
                'short_description_pt' => 'Short Description Portugal',
            ],
            [
                'title' => 'Title English 2',
                'title_es' => 'Title Es 2',
                'title_pt' => 'Title Pt 2',
                'link' => 'link English 2',
                'link_es' => 'link ES 2',
                'link_pt' => 'link PT 2',
                'short_description' => 'Short Description English 2',
                'short_description_es' => 'Short Description Espanish 2',
                'short_description_pt' => 'Short Description Portugal 2',
            ]


        ];

        foreach ($data as $key => $item) {
        
            Slider::create($item);
        }

    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
