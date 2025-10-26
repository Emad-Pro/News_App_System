<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleMedia;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. إنشاء مستخدم أدمن يمكنك استخدامه للدخول
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. إنشاء 10 مستخدمين عاديين
        User::factory(10)->create();

        // 3. إنشاء 5 فئات
        Category::factory(5)->create();
        
        // 4. إنشاء 10 وسوم (Tags)
        $tags = Tag::factory(10)->create();

        // 5. إنشاء 25 مقالاً
        Article::factory(25)
            ->has(ArticleMedia::factory()->count(3), 'media') // لكل مقال، أنشئ 3 ملفات ميديا فرعية
            ->create()
            ->each(function ($article) use ($tags) {
                // لكل مقال، اربطه بـ 3 وسوم عشوائية
                $article->tags()->attach(
                    $tags->random(3)->pluck('id')->toArray()
                );
            });
    }
}