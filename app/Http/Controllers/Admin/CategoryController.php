<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = \App\Models\Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        \App\Models\Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'تمت إضافة الفئة بنجاح.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
public function edit(\App\Models\Category $category)
{
    return view('admin.categories.edit', compact('category'));
}

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, \App\Models\Category $category)
{
    $request->validate([
        // تأكد من أن الاسم فريد، مع تجاهل الفئة الحالية
        'name' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)],
    ]);

    $category->update([
        'name' => $request->name,
        'slug' => Str::slug($request->name),
    ]);

    return redirect()->route('admin.categories.index')->with('success', 'تم تحديث الفئة بنجاح.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
