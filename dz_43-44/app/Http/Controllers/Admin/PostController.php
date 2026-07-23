<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Список постов.
     * Категория получается через отношение Post::category(),
     * а with('category') делает жадную загрузку (eager loading):
     * вместо 1 + N запросов (по одному на категорию каждого поста)
     * выполняется всего 2 запроса — решение N+1 проблемы.
     */
    public function index()
    {
        $posts = Post::with('category')
            ->orderByDesc('id')
            ->paginate(10);

        return view('admin.posts', ['posts' => $posts]);
    }

    /**
     * Форма создания поста.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.posts-create', ['categories' => $categories]);
    }

    /**
     * Сохранение нового поста.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'content' => ['required', 'string'],
        ]);

        Post::create($validated);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Пост создан');
    }

    /**
     * Форма редактирования поста.
     * findOrFail сам вернёт 404, если поста с таким id нет.
     */
    public function edit(int $id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::orderBy('name')->get();

        return view('admin.posts-edit', ['post' => $post, 'categories' => $categories]);
    }

    /**
     * Обновление поста.
     */
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'content' => ['required', 'string'],
        ]);

        $post = Post::findOrFail($id);
        $post->update($validated);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Пост обновлён');
    }

    /**
     * Удаление поста.
     */
    public function destroy(int $id)
    {
        Post::findOrFail($id)->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Пост удалён');
    }
}
