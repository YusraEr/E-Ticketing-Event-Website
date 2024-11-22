<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [
            ['name' => 'Konser dan Musik', 'description' => 'Acara musik dan konser dari berbagai genre.'],
            ['name' => 'Olahraga', 'description' => 'Berbagai acara olahraga dan kompetisi.'],
            ['name' => 'Teater dan Seni Pertunjukan', 'description' => 'Pertunjukan teater dan seni panggung.'],
            ['name' => 'Konferensi dan Seminar', 'description' => 'Acara konferensi dan seminar untuk berbagai topik.'],
            ['name' => 'Pameran dan Expo', 'description' => 'Pameran dan expo dari berbagai industri.'],
            ['name' => 'Acara Keluarga dan Anak-anak', 'description' => 'Acara yang cocok untuk keluarga dan anak-anak.'],
            ['name' => 'Festival dan Perayaan', 'description' => 'Berbagai festival dan perayaan budaya.'],
            ['name' => 'Acara Komunitas', 'description' => 'Acara yang diselenggarakan oleh komunitas lokal.'],
            ['name' => 'Film dan Media', 'description' => 'Pemutaran film dan acara terkait media.'],
            ['name' => 'Acara Virtual', 'description' => 'Acara yang diselenggarakan secara virtual.'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'description' => $category['description'],
            ]);
        }
    }
}
