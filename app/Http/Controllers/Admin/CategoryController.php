<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Список категорий.
     * Количество постов считается через отношение Category::posts():
     * withCount('posts') добавляет колонку posts_count одним подзапросом,
     * без отдельного COUNT-запроса на каждую категорию (без N+1 проблемы).
     */
    public function index()
    {
        $categories = Category::withCount('posts')
            ->orderBy('id')
            ->paginate(5);

        return view('admin.categories', ['categories' => $categories]);
    }

    /**
     * Форма создания категории.
     */
    public function create()
    {
        return view('admin.categories-create');
    }

    /**
     * Сохранение новой категории.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:categories,slug'],
            'description' => ['nullable', 'string'],
        ]);

        Category::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'] ?: Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Категория создана');
    }

    /**
     * Форма редактирования категории.
     */
    public function edit(int $id)
    {
        $category = Category::findOrFail($id);

        return view('admin.categories-edit', ['category' => $category]);
    }

    /**
     * Обновление категории.
     */
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:categories,slug,' . $id],
            'description' => ['nullable', 'string'],
        ]);

        $category = Category::findOrFail($id);

        $category->update([
            'name' => $validated['name'],
            'slug' => $validated['slug'] ?: Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Категория обновлена');
    }

    /**
     * Удаление категории.
     * Количество постов проверяется через отношение posts().
     * Если в категории ещё есть посты — удаление отклоняется
     * (иначе упрёмся в ограничение внешнего ключа category_id на таблице posts).
     */
    public function destroy(int $id)
    {
        $category = Category::findOrFail($id);

        $postsCount = $category->posts()->count();

        if ($postsCount > 0) {
            $word = $this->pluralizePosts($postsCount);

            return redirect()
                ->route('admin.categories.index')
                ->with('error', "Нельзя удалить категорию: в ней {$postsCount} {$word}. Сначала удалите или перенесите эти посты в другую категорию.");
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Категория удалена');
    }

    /**
     * Русское склонение слова "пост" по числу (1 пост, 2 поста, 5 постов).
     */
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
