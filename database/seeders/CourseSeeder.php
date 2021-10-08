<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Rating;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $silabus = ['Example 1', 'Example 2', 'Example 3', 'Example 4', 'Example 5'];

        Course::create([
            'name' => 'Bermain gitar yang benar',
            'slug' => 'bermain-gitar-yang-benar',
            'category_id' => 3,
            'user_id' => 3,
            'company_id' => 1,
            'image' => env('APP_URL').'/course/1605857358.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di Course ini kita akan belajar cara bermain gitar yang benar dari basic nya hingga advance.',
            'price' => '150000',
            'silabus' => ['Memegang gitar', 'Kunci gitar', 'Memetik gitar', 'Merusak gitar', 'Menghancurkan gitar', 'Membuat gitar', 'Membakar gitar'],
        ]);

        Course::create([
            'name' => 'Editing video seperti film-film Hollywood',
            'slug' => 'editing-video-seperti-film-film-hollywood',
            'category_id' => 2,
            'user_id' => 3,
            'company_id' => 1,
            'image' => env('APP_URL').'/course/1605858686.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di Course ini kita akan belajar cara mengedit video yang hasilnya seperti film-film Hollywood.',
            'price' => '0',
            'is_paid' => false,
            'silabus' => $silabus,
        ]);

        Course::create([
            'name' => 'Belajar Database Postgresql',
            'slug' => 'belajar-database-postgresql',
            'category_id' => 4,
            'user_id' => 3,
            'company_id' => 1,
            'image' => 'https://cdn.educba.com/academy/wp-content/uploads/2020/02/PostgreSQL-Features.jpg',
            'preview' => 'QXiURudUHFE',
            'about' => 'PostgreSQL adalah sebuah sistem basis data yang disebarluaskan secara bebas menurut Perjanjian lisensi BSD. Peranti lunak ini merupakan salah satu basis data yang paling banyak digunakan saat ini, selain MySQL dan Oracle. PostgreSQL menyediakan fitur yang berguna untuk replikasi basis data.',
            'price' => '120000',
            'silabus' => [
                'Pengenalan RDBMS',
                'Setup Development Environment',
                'Select Statement & Alias dengan PostgreSQL',
                'Operasi Aritmatika di PostgreSQL',
                'Keyword Distinct di Postgresql',
                'Null and Empty String Handler',
                'Filter data di PostgreSQL',
                'Operator for Filter data dengan where clause di PostgreSQL',
            ],
        ]);

        Course::create([
            'name' => 'Bermain piano yang benar',
            'slug' => 'bermain-piano-yang-benar',
            'category_id' => 3,
            'user_id' => 3,
            'image' => env('APP_URL').'/course/1605858877.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di Course ini kita akan belajar cara bermain piano yang benar dari basic nya hingga advance.',
            'price' => '190000',
            'silabus' => $silabus,
        ]);

        Course::create([
            'name' => 'Editing foto seperti film-film Hollywood',
            'slug' => 'editing-foto-seperti-film-film-hollywood',
            'category_id' => 1,
            'user_id' => 3,
            'image' => env('APP_URL').'/course/1605859173.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di Course ini kita akan belajar cara mengedit foto yang hasilnya seperti film-film Hollywood.',
            'price' => '230000',
            'silabus' => $silabus,
        ]);
        Course::create([
            'name' => 'Bermain karet yang benar',
            'slug' => 'bermain-karet-yang-benar',
            'category_id' => 4,
            'user_id' => 4,
            'company_id' => 1,
            'image' => env('APP_URL').'/course/1605859321.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di Course ini kita akan belajar cara bermain karet yang benar dari basic nya hingga advance.',
            'price' => '100000',
            'silabus' => $silabus,
        ]);

        Course::create([
            'name' => 'Editing game seperti film-film Hollywood',
            'slug' => 'editing-game-seperti-film-film-hollywood',
            'category_id' => 1,
            'user_id' => 4,
            'image' => env('APP_URL').'/course/1605859585.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di Course ini kita akan belajar cara game video yang hasilnya seperti film-film Hollywood.',
            'price' => '230000',
            'silabus' => $silabus,
        ]);
        Course::create([
            'name' => 'Bermain bekel yang benar',
            'slug' => 'bermain-bekel-yang-benar',
            'category_id' => 2,
            'user_id' => 4,
            'company_id' => 2,
            'image' => env('APP_URL').'/course/1605859599.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di Course ini kita akan belajar cara bermain bekel yang benar dari basic nya hingga advance.',
            'price' => '120000',
            'silabus' => $silabus,
        ]);

        Course::create([
            'name' => 'Editing sendal seperti film-film Hollywood',
            'slug' => 'editing-sendal-seperti-film-film-hollywood',
            'category_id' => 2,
            'user_id' => 4,
            'company_id' => 2,
            'image' => env('APP_URL').'/course/1605859951.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di Course ini kita akan belajar cara mengedit sendal yang hasilnya seperti film-film Hollywood.',
            'price' => '180000',
            'silabus' => $silabus,
        ]);

        Course::create([
            'name' => 'Dummy 1',
            'slug' => 'editing-sendal-seperti-film-film-hollywood',
            'category_id' => 2,
            'user_id' => 4,
            'company_id' => 2,
            'image' => env('APP_URL').'/course/1605859951.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di Course ini kita akan belajar cara mengedit sendal yang hasilnya seperti film-film Hollywood.',
            'price' => '180000',
            'silabus' => $silabus,
        ]);

        Course::create([
            'name' => 'Dummy 2',
            'slug' => 'editing-sendal-seperti-film-film-hollywood',
            'category_id' => 2,
            'user_id' => 5,
            'company_id' => 2,
            'image' => env('APP_URL').'/course/1605859951.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di Course ini kita akan belajar cara mengedit sendal yang hasilnya seperti film-film Hollywood.',
            'price' => '180000',
            'silabus' => $silabus,
        ]);

        Course::create([
            'name' => 'Dummy 3',
            'slug' => 'editing-sendal-seperti-film-film-hollywood',
            'category_id' => 3,
            'user_id' => 5,
            'company_id' => 2,
            'image' => env('APP_URL').'/course/1605859951.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di Course ini kita akan belajar cara mengedit sendal yang hasilnya seperti film-film Hollywood.',
            'price' => '180000',
            'silabus' => $silabus,
        ]);

        Course::create([
            'name' => 'Dummy 4',
            'slug' => 'editing-sendal-seperti-film-film-hollywood',
            'category_id' => 4,
            'user_id' => 5,
            'company_id' => 1,
            'image' => env('APP_URL').'/course/1605859951.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di Course ini kita akan belajar cara mengedit sendal yang hasilnya seperti film-film Hollywood.',
            'price' => '180000',
            'silabus' => $silabus,
        ]);

        Course::create([
            'name' => 'Dummy 5',
            'slug' => 'editing-sendal-seperti-film-film-hollywood',
            'category_id' => 3,
            'user_id' => 5,
            'image' => env('APP_URL').'/course/1605859951.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di Course ini kita akan belajar cara mengedit sendal yang hasilnya seperti film-film Hollywood.',
            'price' => '180000',
            'silabus' => $silabus,
        ]);

        Course::create([
            'name' => 'Dummy 6',
            'slug' => 'editing-sendal-seperti-film-film-hollywood',
            'category_id' => 3,
            'user_id' => 5,
            'image' => env('APP_URL').'/course/1605859951.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di Course ini kita akan belajar cara mengedit sendal yang hasilnya seperti film-film Hollywood.',
            'price' => '180000',
            'silabus' => $silabus,
        ]);

        Course::create([
            'name' => 'Dummy 7',
            'slug' => 'editing-sendal-seperti-film-film-hollywood',
            'category_id' => 4,
            'user_id' => 5,
            'image' => env('APP_URL').'/course/1605859951.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di Course ini kita akan belajar cara mengedit sendal yang hasilnya seperti film-film Hollywood.',
            'price' => '180000',
            'silabus' => $silabus,
        ]);

        Course::create([
            'name' => 'Dummy 8',
            'slug' => 'editing-sendal-seperti-film-film-hollywood',
            'category_id' => 4,
            'user_id' => 5,
            'image' => env('APP_URL').'/course/1605859951.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di Course ini kita akan belajar cara mengedit sendal yang hasilnya seperti film-film Hollywood.',
            'price' => '180000',
            'silabus' => $silabus,
        ]);

        Course::create([
            'name' => 'Dummy 9',
            'slug' => 'editing-sendal-seperti-film-film-hollywood',
            'category_id' => 4,
            'user_id' => 5,
            'image' => env('APP_URL').'/course/1605859951.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di Course ini kita akan belajar cara mengedit sendal yang hasilnya seperti film-film Hollywood.',
            'price' => '180000',
            'silabus' => $silabus,
        ]);

        Course::create([
            'name' => 'Dummy 10',
            'slug' => 'editing-sendal-seperti-film-film-hollywood',
            'category_id' => 4,
            'user_id' => 5,
            'image' => env('APP_URL').'/course/1605859951.png',
            'preview' => 'QXiURudUHFE',
            'about' => 'Di Course ini kita akan belajar cara mengedit sendal yang hasilnya seperti film-film Hollywood.',
            'price' => '180000',
            'silabus' => $silabus,
        ]);
        Rating::factory(200)->create();
    }
}
