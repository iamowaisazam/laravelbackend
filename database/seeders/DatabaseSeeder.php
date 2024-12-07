<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Arr;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

    Category::select('*')->delete();
    Post::select('*')->delete();

    Category::create(['title_en' =>'NOTICIAS','title_es'=>'NOTICIAS','title_pt' => 'NOTICIAS']);
    Category::create(['title_en' =>'TALLER','title_es'=>'TALLER','title_pt' =>'TALLER']);
    Category::create(['title_en' =>'REVISTA','title_es'=>'REVISTA','title_pt'=>'REVISTA']);
    Category::create(['title_en' =>'Artículos','title_es' => 'Artículos','title_pt' => 'Artículos']);
    Category::create(['title_en' =>'Congresos','title_es' => 'Congresos','title_pt' => 'Congresos']);
    Category::create(['title_en' =>'Eventos','title_es' => 'Eventos','title_pt' => 'Eventos']);
    Category::create(['title_en' =>'Publicaciones','title_es' => 'Publicaciones','title_pt' => 'Publicaciones']);
    Category::create(['title_en' =>'Webinars','title_es' => 'Webinars','title_pt' => 'Webinars']);


    $types = ['post','pdf'];

        foreach (range(1,200) as $key => $item) {

            $faker = Faker::create();
            $title = $faker->sentence;
            $name = $faker->name;
            $pdf = "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf";
            $short_description = substr($faker->paragraph, 0, 300);
            $long_description = $faker->paragraph;
            $banner = $faker->imageUrl(1200, 400, 'business', true, 'Faker Banner');

            $item = [];
            $item['thumbnail_en'] = 'uploads/greybox.png';
            $item['thumbnail_es'] = 'uploads/greybox.png';
            $item['thumbnail_pt'] = 'uploads/greybox.png';

            $item['creater_en'] = 'Administrador';
            $item['creater_es'] = 'Administrador';
            $item['creater_pt'] = 'Administrador';

            $item['title_en'] = $title;
            $item['title_es'] = $title;
            $item['title_pt'] = $title;

            $item['short_description_en'] = $short_description;
            $item['short_description_es'] = $short_description;
            $item['short_description_pt'] = $short_description;

            $item['long_description_en'] = $long_description;
            $item['long_description_es'] = $long_description;
            $item['long_description_pt'] = $long_description;

            $item['banner_en'] = $banner;
            $item['banner_es'] = $banner;
            $item['banner_pt'] = $banner;

            $item['author_en'] =  $name;
            $item['author_es'] =  $name;
            $item['author_pt'] =  $name;

            $item['pdf_en'] =  $pdf;
            $item['pdf_es'] =  $pdf;
            $item['pdf_pt'] =  $pdf;

            $item['views_en'] =  $faker->numberBetween(1, 100);
            $item['views_es'] =  $faker->numberBetween(1, 100);
            $item['views_pt'] =  $faker->numberBetween(1, 100);

            $item['like_en'] =  $faker->numberBetween(1, 100);
            $item['like_es'] =  $faker->numberBetween(1, 100);
            $item['like_pt'] =  $faker->numberBetween(1, 100);


            $item['slug'] = Str::slug($title);
            $item['is_featured'] = 1;
            $item['status'] = 1;
            $item['category_id'] = Category::inRandomOrder()->first()->id;
            $item['type'] = Arr::random($types);
            $item['created_at'] = $faker->dateTimeBetween('-10 years', 'now');

            Post::create($item);

        }


    }

    
}