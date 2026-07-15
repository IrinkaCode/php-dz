<?php

namespace Database\Seeders;

use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Сколько постов сгенерировать.
     */
    protected int $count = 30;

    public function run(): void
    {
        $faker = FakerFactory::create('ru_RU');

        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        if (empty($categoryIds)) {
            $this->command?->warn('Нет категорий — сначала выполните CategorySeeder.');

            return;
        }

        $posts = [];

        for ($i = 0; $i < $this->count; $i++) {
            $posts[] = [
                'title' => rtrim($faker->sentence(random_int(4, 8)), '.'),
                'content' => $faker->realText(800),
                'image' => null,
                'category_id' => $faker->randomElement($categoryIds),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('posts')->insert($posts);

        $this->command?->info('Посты созданы: ' . count($posts));
    }
}
