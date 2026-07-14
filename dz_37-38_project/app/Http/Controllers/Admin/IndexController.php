<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function __invoke()
    {
        $postsCount = DB::table('posts')->count();
        $categoriesCount = DB::table('categories')->count();

        return view('admin.index', [
            'postsCount' => $postsCount,
            'categoriesCount' => $categoriesCount,
        ]);
    }
}
