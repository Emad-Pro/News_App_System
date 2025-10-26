<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // دالة لعرض كل الفئات
    public function index()
    {
        return response()->json(Category::all());
    }

    // دالة لعرض مقالات فئة معينة
    public function articles(Category $category)
    {
        $articles = $category->articles()
                              ->where('status', 'published')
                              ->with('user') // لا نحتاج الفئة لأننا نعرفها بالفعل
                              ->latest('published_at')
                              ->paginate(10);

        return response()->json($articles);
    }
}