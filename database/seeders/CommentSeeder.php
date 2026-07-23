<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $postIds = Post::pluck('id');
        $userIds = User::pluck('id');

        if ($postIds->isEmpty() || $userIds->isEmpty()) {
            $this->command?->warn('Нет постов или пользователей — сначала выполните PostSeeder и UserSeeder.');

            return;
        }

        $total = 0;

        // На каждый пост — от 0 до 5 случайных комментариев от случайных пользователей.
        foreach ($postIds as $postId) {
            $commentsCount = random_int(0, 5);

            for ($i = 0; $i < $commentsCount; $i++) {
                Comment::factory()->create([
                    'post_id' => $postId,
                    'user_id' => $userIds->random(),
                ]);

                $total++;
            }
        }

        $this->command?->info('Комментарии созданы: ' . $total);
    }
}
