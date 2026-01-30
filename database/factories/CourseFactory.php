<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CourseFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->sentence(3);
        return [
            'name' => $name,
            'slug' => Str::slug($name . '-' . $this->faker->unique()->randomNumber()),
            'path_trailer' => null,
            'about' => $this->faker->paragraph(),
            'thumbnail' => null,
            'teacher_id' => Teacher::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
