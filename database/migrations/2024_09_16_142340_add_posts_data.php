<?php

use App\Models\Post;
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
                'title' => 'El CLAD dirá presente en «States of the Future» en Brasil.',
            ],
            [
                'title' => 'El CLAD realiza taller en Design Thinking para potenciar su plataforma tecnológica',
            ],
            [
                'title' => 'El CLAD y el KIPA se reúnen en Corea del Sur en aras de crear alianzas.',
            ],
            [
                'title' => 'La “Revista del CLAD Reforma y Democracia” inicia su proceso de digitalización'
            ]
        ];

        foreach ($data as $key => $item) {

            $item['thumbnail_en'] = 'uploads/post.png';
            $item['thumbnail_es'] = 'uploads/post.png';
            $item['thumbnail_pt'] = 'uploads/post.png';

            $item['title_en'] = $item['title'];
            $item['title_es'] = $item['title'];
            $item['title_pt'] = $item['title'];

            $item['slug'] = Str::slug($item['title']);
            $item['is_featured'] = 1;
            $item['status'] = 1;
            $item['type'] = 'post';

            Post::create($item);
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
