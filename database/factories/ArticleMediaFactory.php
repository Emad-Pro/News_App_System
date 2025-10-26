<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleMediaFactory extends Factory
{
    public function definition(): array
    {
        $type = $this->faker->randomElement(['image', 'video']);
        $path = $type === 'image'
            ? 'https://via.placeholder.com/1280x720.png/00dd88?text=Image' // رابط صورة وهمية
            : 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'; // رابط فيديو وهمي

        return [
            'path' => $path,
            'type' => $type,
        ];
    }
}