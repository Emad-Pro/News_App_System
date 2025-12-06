<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Category;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        // 1. توليد اسم صورة عشوائي
        $imageName = Str::random(10) . '.jpg';
        $imagePath = 'articles/featured/' . $imageName;

        // 2. تحميل صورة عشوائية حقيقية من Lorem Picsum
        // نستخدم try/catch لتجنب توقف السكربت لو النت بطيء
        try {
            $contents = file_get_contents('https://picsum.photos/640/480');
            Storage::disk('public')->put($imagePath, $contents);
        } catch (\Exception $e) {
            $imagePath = null; // في حالة الفشل نتركها فارغة
        }

        return [
            'title' => $this->faker->sentence(),
            'slug' => $this->faker->slug(),
            'content' => $this->faker->paragraph(5),
            'featured_image' => $imagePath, // حفظ المسار
            'status' => 'published',
            'published_at' => now(),
            'comments_enabled' => true,
            'views_count' => rand(10, 5000),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
        ];
    }
}