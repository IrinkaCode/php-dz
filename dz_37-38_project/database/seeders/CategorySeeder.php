<?php

namespace Database\Seeders;

use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Заранее заданные названия категорий (чтобы они были осмысленными),
     * остальные поля (slug, description) генерируются через Faker.
     */
    protected array $names = [
        'PHP',
        'Laravel',
        'JavaScript',
        'Базы данных',
        'Оптимизация',
        'DevOps',
    ];

    public function run(): void
    {
        $faker = FakerFactory::create('ru_RU');

        $categories = [];

        foreach ($this->names as $name) {
            $categories[] = [
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => $faker->sentence(10),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('categories')->insert($categories);

        $this->command?->info('Категории созданы: ' . count($categories));
    }
}
