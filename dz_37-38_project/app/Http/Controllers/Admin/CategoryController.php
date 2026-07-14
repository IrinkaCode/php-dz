<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = DB::table('categories')
            ->leftJoin('posts', 'posts.category_id', '=', 'categories.id')
            ->select('categories.*', DB::raw('count(posts.id) as posts_count'))
            ->groupBy('categories.id', 'categories.name', 'categories.slug', 'categories.description', 'categories.created_at', 'categories.updated_at')
            ->orderBy('categories.name')
            ->get();

        return view('admin.categories', ['categories' => $categories]);
    }

    public function create()
    {
        return view('admin.categories-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:categories,slug'],
            'description' => ['nullable', 'string'],
        ]);

        DB::table('categories')->insert([
            'name' => $validated['name'],
            'slug' => $validated['slug'] ?: Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Категория создана');
    }

    public function edit(int $id)
    {
        $category = DB::table('categories')->find($id);

        abort_if(!$category, 404);

        return view('admin.categories-edit', ['category' => $category]);
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:categories,slug,' . $id],
            'description' => ['nullable', 'string'],
        ]);

        DB::table('categories')->where('id', $id)->update([
            'name' => $validated['name'],
            'slug' => $validated['slug'] ?: Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Категория обновлена');
    }

    public function destroy(int $id)
    {
        $postsCount = DB::table('posts')->where('category_id', $id)->count();

        if ($postsCount > 0) {
            $word = $this->pluralizePosts($postsCount);

            return redirect()
                ->route('admin.categories.index')
                ->with('error', "Нельзя удалить категорию: в ней {$postsCount} {$word}. Сначала удалите или перенесите эти посты в другую категорию.");
        }

        DB::table('categories')->where('id', $id)->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Категория удалена');
    }

    protected function pluralizePosts(int $count): string
    {
        $mod100 = $count % 100;
        $mod10 = $count % 10;

        if ($mod100 >= 11 && $mod100 <= 14) {
            return 'постов';
        }

        return match (true) {
            $mod10 === 1 => 'пост',
            $mod10 >= 2 && $mod10 <= 4 => 'поста',
            default => 'постов',
        };
    }
}
