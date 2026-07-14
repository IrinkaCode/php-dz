<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Список постов вместе с названием их категории (JOIN через DB).
     */
    public function index()
    {
        $posts = DB::table('posts')
            ->join('categories', 'categories.id', '=', 'posts.category_id')
            ->select('posts.*', 'categories.name as category_name')
            ->orderBy('posts.id', 'desc')
            ->get();

        return view('posts', ['posts' => $posts]);
    }

    public function show(int $id)
    {
        $post = DB::table('posts')
            ->join('categories', 'categories.id', '=', 'posts.category_id')
            ->select('posts.*', 'categories.name as category_name')
            ->where('posts.id', $id)
            ->first();

        return view('post', ['post' => $post]);
    }
}
