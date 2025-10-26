<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ArticleMedia;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
class ArticleController extends Controller
{
    public function index(Request $request)
{
    // 1. ابدأ ببناء الاستعلام الأساسي
    $query = Article::with('user', 'category', 'likes') // أضفنا 'likes' لجلب عدد المعجبين
                    ->latest();

    // 2. تطبيق البحث إذا كان موجودًا
    if ($request->has('search') && $request->search != '') {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    // 3. تطبيق الفلترة حسب الفئة إذا كانت موجودة
    if ($request->has('category') && $request->category != '') {
        $query->where('category_id', $request->category);
    }

    // 4. تنفيذ الاستعلام مع تقسيم النتائج
    $articles = $query->paginate(10)->withQueryString(); // withQueryString() مهم للحفاظ على الفلاتر عند التنقل بين الصفحات

    // 5. جلب كل الفئات لعرضها في قائمة الفلترة
    $categories = Category::all();

    return view('admin.articles.index', compact('articles', 'categories'));
}

    public function create()
    {
        $categories = Category::all();
        return view('admin.articles.create', compact('categories'));
    }

// لا تنسَ إضافة هذه السطورة في الأعلى إذا لم تكن موجودة


// ... داخل ArticleController

public function store(Request $request)
{
    // 1. التحقق من صحة البيانات المدخلة
    $data = $request->validate([
        'title' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'content' => 'required|string',
        'featured_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // الصورة الرئيسية
        'status' => 'required|in:published,draft',
        'published_at' => 'required|date', // حقل وقت النشر
        'media_files' => 'nullable|array', // حقل الوسائط المتعددة
        'media_files.*' => 'file|mimes:jpg,png,jpeg,mp4,mov|max:20480', // 20MB max per file
    ]);

    // 2. معالجة الصورة الرئيسية
    if ($request->hasFile('featured_image')) {
        $data['featured_image'] = $request->file('featured_image')->store('articles/featured', 'public');
    }

    // 3. إعداد بيانات المقال الأساسية
    $data['slug'] = Str::slug($data['title']) . '-' . uniqid();
    $data['user_id'] = auth()->id();
    $data['published_at'] = Carbon::parse($data['published_at']); // تحويل النص إلى تاريخ صحيح

    // 4. إنشاء المقال للحصول على ID
    $article = Article::create($data);

    // 5. معالجة رفع الصور والفيديوهات الفرعية
    if ($request->hasFile('media_files')) {
        foreach ($request->file('media_files') as $file) {
            // تحديد نوع الملف (صورة أو فيديو)
            $type = Str::startsWith($file->getMimeType(), 'video') ? 'video' : 'image';
            
            // تخزين الملف
            $path = $file->store('articles/media', 'public');

            // حفظ المسار في جدول الوسائط
            ArticleMedia::create([
                'article_id' => $article->id,
                'path' => $path,
                'type' => $type,
            ]);
        }
    }

    return redirect()->route('admin.articles.index')->with('success', 'تم إنشاء المقال بنجاح.');
}
public function show(Article $article)
{
    // استخدام Eager Loading لجلب كل العلاقات المطلوبة بكفاءة عالية
    // 'likes' تجلب قائمة المستخدمين المعجبين
    // 'comments.user' تجلب التعليقات مع بيانات كاتب كل تعليق
    $article->load('likes', 'comments.user');

    return view('admin.articles.show', compact('article'));
}
public function edit(Article $article)
{
    // نحتاج لجلب الفئات لعرضها في القائمة المنسدلة
    $categories = Category::all();
    
    // إرجاع واجهة التعديل مع تمرير بيانات المقال والفئات
    return view('admin.articles.edit', compact('article', 'categories'));
}

public function update(Request $request, Article $article)
{
    // 1. التحقق من صحة البيانات المدخلة
    $data = $request->validate([
        'title' => ['required', 'string', 'max:255', Rule::unique('articles')->ignore($article->id)],
        'category_id' => 'required|exists:categories,id',
        'content' => 'required|string',
        'featured_image' => 'nullable|image|max:2048',
        'status' => 'required|in:published,draft',
        'published_at' => 'required|date',
    ]);

    // 2. التحقق من وجود صورة رئيسية جديدة
    if ($request->hasFile('featured_image')) {
        // حذف الصورة القديمة إذا كانت موجودة
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }
        // تخزين الصورة الجديدة
        $data['featured_image'] = $request->file('featured_image')->store('articles/featured', 'public');
    }

    // 3. تحديث بيانات المقال
    $article->update($data);

    // يمكنك إضافة منطق تحديث الصور والفيديوهات الفرعية هنا بنفس طريقة دالة store

    return redirect()->route('admin.articles.index')->with('success', 'تم تحديث المقال بنجاح.');
}

    public function destroy(Article $article)
    {
        // ... (منطق الحذف مع حذف الصورة)
        // ...
        $article->delete();
        return back()->with('success', 'تم حذف المقال بنجاح.');
    }
}