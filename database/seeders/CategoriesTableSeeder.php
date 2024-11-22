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
            'Konser dan Musik',
            'Olahraga',
            'Teater dan Seni Pertunjukan',
            'Konferensi dan Seminar',
            'Pameran dan Expo',
            'Acara Keluarga dan Anak-anak',
            'Festival dan Perayaan',
            'Acara Komunitas',
            'Film dan Media',
            'Acara Virtual',
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category,
            ]);
        }
    }
}
