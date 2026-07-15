<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Список постов вместе с категорией (JOIN через DB).
     */
    public function index()
    {
        $posts = DB::table('posts')
            ->join('categories', 'categories.id', '=', 'posts.category_id')
            ->select('posts.*', 'categories.name as category_name')
            ->orderBy('posts.id', 'desc')
            ->paginate(10);

        return view('admin.posts', ['posts' => $posts]);
    }

    /**
     * Форма создания поста.
     */
    public function create()
    {
        $categories = DB::table('categories')->orderBy('name')->get();

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

        DB::table('posts')->insert([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'content' => $validated['content'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Пост создан');
    }

    /**
     * Форма редактирования поста.
     */
    public function edit(int $id)
    {
        $post = DB::table('posts')->find($id);
        $categories = DB::table('categories')->orderBy('name')->get();

        abort_if(!$post, 404);

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

        DB::table('posts')->where('id', $id)->update([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'content' => $validated['content'],
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Пост обновлён');
    }

    /**
     * Удаление поста.
     */
    public function destroy(int $id)
    {
        DB::table('posts')->where('id', $id)->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Пост удалён');
    }
}
