<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;


class TourVariantTableSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        /*$count_person = [
            "1 человек",
            "2 человека",
            "3 человека",
            "4 человека",
            "5 человек",
            "от 5 до 10 человек",
            "от 10 до 20 человек",
            "от 20 до 50 человек"
        ];*/

        $variants = [];

        for ($i = 0; $i<5; $i++){
            $amount_variant = random_int(1, 50);
            $variant = [
                'tour_id' => 1,
                'price_variant' => random_int(10000, 157000),
                'photo_variant' => '['.json_encode(asset('assets/site/images/home_bg_new.jpg')).']',
                'date_start_variant' => $faker->date(),
                'date_end_variant' => $faker->date(),
                'text_variant' => $faker->paragraph(),
                'amount_variant' => $amount_variant,
                'signed_up' => $amount_variant,
            ];
            $variants[] = $variant;
        }
        DB::table('tours_variants')->insert($variants);
    }
}


