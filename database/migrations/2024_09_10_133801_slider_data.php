<?php

use App\Models\Post;
use App\Models\Slider;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

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

        foreach ($data as $key => $item) {

            $item['thumbnail_en'] = 'uploads/slide.png';
            $item['thumbnail_es'] = 'uploads/slide.png';
            $item['thumbnail_pt'] = 'uploads/slide.png';

            $item['link_en'] = 'link';
            $item['link_es'] = 'link';
            $item['link_pt'] = 'link';

            $item['title_en'] = $item['title'];
            $item['title_es'] = $item['title'];
            $item['title_pt'] = $item['title'];

            // $item['slug'] = Str::slug($item['title']);
            // $item['is_featured'] = 1;
            $item['status'] = 1;
            // $item['type'] = 'post';

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
