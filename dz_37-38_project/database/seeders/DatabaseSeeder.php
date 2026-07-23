<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Отключаем проверку внешних ключей на время очистки таблиц,
        // чтобы порядок truncate не имел значения (SQLite / MySQL).
        Schema::disableForeignKeyConstraints();

        DB::table('posts')->truncate();
        DB::table('categories')->truncate();

        Schema::enableForeignKeyConstraints();

        // Сиды разбиты на отдельные файлы и запускаются через call().
        // Порядок важен: сначала категории, затем посты (нужен category_id).
        $this->call([
            CategorySeeder::class,
            PostSeeder::class,
        ]);

        // User::factory(10)->create();
    }
}
