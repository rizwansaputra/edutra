<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseKeypointFactory extends Factory
{
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'name' => $this->faker->sentence(6),
        ];
    }
}
