<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleMedia;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // ✅ ضروري للتعامل مع الملفات

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 0. تنظيف مجلد الصور القديم لضمان بداية نظيفة
        Storage::disk('public')->deleteDirectory('articles/featured');
        Storage::disk('public')->makeDirectory('articles/featured');
        
        // تنظيف مجلد الوسائط (للفيديوهات والصور الإضافية)
        Storage::disk('public')->deleteDirectory('articles/media');
        Storage::disk('public')->makeDirectory('articles/media');

        // 1. إنشاء مستخدم أدمن
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com', // سهلت الإيميل للدخول
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. إنشاء 10 مستخدمين عاديين
        User::factory(10)->create();

        // 3. إنشاء 5 فئات
        Category::factory(5)->create();
        
        // 4. إنشاء 10 وسوم (Tags)
        $tags = Tag::factory(10)->create();

        echo "جارٍ تحميل الصور وإنشاء المقالات... يرجى الانتظار قليلاً...\n";

        // 5. إنشاء 25 مقال
        Article::factory(25)
            ->has(ArticleMedia::factory()->count(3), 'media') // 3 ملفات ميديا لكل مقال
            ->create()
            ->each(function ($article) use ($tags) {
                // ربط 3 وسوم عشوائية
                $article->tags()->attach(
                    $tags->random(3)->pluck('id')->toArray()
                );
            });
            
        echo "✅ تم الانتهاء بنجاح!\n";
    }
}