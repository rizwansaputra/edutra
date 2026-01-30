<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\CourseKeypoint;
use App\Models\CourseVideo;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class InitialSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        $admin   = Role::firstOrCreate(['name' => 'admin']);
        $teacher = Role::firstOrCreate(['name' => 'teacher']);
        $student = Role::firstOrCreate(['name' => 'student']);

        // Admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => bcrypt('password')]
        );
        $adminUser->assignRole($admin);

        // Teacher user
        $teacherUser = User::firstOrCreate(
            ['email' => 'teacher@example.com'],
            ['name' => 'Guru 1', 'password' => bcrypt('password')]
        );
        $teacherUser->assignRole($teacher);

        $teacherModel = Teacher::firstOrCreate(['user_id' => $teacherUser->id], [
            'is_active' => true
        ]);

        // Categories + Courses sample
        Category::factory(4)->create()->each(function ($cat) use ($teacherModel) {
            $course = Course::factory()->create([
                'category_id' => $cat->id,
                'teacher_id'  => $teacherModel->id,
            ]);

            CourseKeypoint::factory(3)->create(['course_id' => $course->id]);
            CourseVideo::factory(2)->create(['course_id' => $course->id]);
        });
    }
}
