<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence(6);
        return [
            'user_id' => User::inRandomOrder()->first()->id, // اختر كاتب عشوائي
            'category_id' => Category::inRandomOrder()->first()->id, // اختر فئة عشوائية
            'title' => $title,
            'slug' => Str::slug($title) . '-' . uniqid(),
            'content' => $this->faker->paragraphs(10, true), // 10 فقرات نصية
            'featured_image' => 'https://via.placeholder.com/1280x720.png/0077be?text=Featured',
            'status' => 'published',
            'views_count' => $this->faker->numberBetween(100, 5000),
            'published_at' => now()->subDays($this->faker->numberBetween(1, 30)),
        ];
    }
}