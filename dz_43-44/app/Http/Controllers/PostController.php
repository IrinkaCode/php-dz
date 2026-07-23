<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Список всех постов + меню категорий для фильтрации.
     */
    public function index()
    {
        $categories = Category::all();
        $posts = Post::with('category')->orderBy('id', 'desc')->paginate(10);

        return view('posts', [
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }

    /**
     * Страница одного поста.
     * $post уже найден через route model binding (Laravel сам делает
     * Post::findOrFail() по {post} из URL — 404, если такого поста нет).
     * Категория и комментарии с авторами подгружаются через отношения.
     */
    public function show(Post $post)
    {
        $post->load(['category', 'comments.user']);

        return view('post', ['post' => $post]);
    }

    /**
     * Посты одной категории.
     * $category найден через route model binding по полю slug ({category:slug} в роуте).
     */
    public function category(Category $category)
    {
        $categories = Category::all();
        $posts = $category->posts()->with('category')->orderBy('id', 'desc')->paginate(10);

        return view('posts', [
            'posts' => $posts,
            'categories' => $categories,
            'category_id' => $category->id,
        ]);
    }
}
