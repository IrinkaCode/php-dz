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

        DB::table('comments')->truncate();
        DB::table('posts')->truncate();
        DB::table('categories')->truncate();
        DB::table('users')->truncate();

        Schema::enableForeignKeyConstraints();

        // Сиды разбиты на отдельные файлы и запускаются через call().
        // Порядок важен: сначала независимые таблицы (categories, users),
        // затем posts (нужен category_id), затем comments (нужны post_id и user_id).
        $this->call([
            CategorySeeder::class,
            UserSeeder::class,
            PostSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
