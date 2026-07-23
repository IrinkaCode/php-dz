<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;

class IndexController extends Controller
{
    public function __invoke()
    {
        return view('admin.index', [
            'postsCount' => Post::count(),
            'categoriesCount' => Category::count(),
        ]);
    }
}
