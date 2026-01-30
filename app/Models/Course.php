<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use App\Models\Teacher;
use App\Models\CourseKeypoint;
use App\Models\CourseVideo;
use App\Models\Pivots\CourseStudentPivot;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'path_trailer',
        'about',
        'thumbnail',
        'teacher_id',
        'category_id',
    ];

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke teacher
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    
    // Keypoints
    public function keypoints()
    {
        return $this->hasMany(CourseKeypoint::class);
    }

    // Video list
    public function videos()
    {
        return $this->hasMany(CourseVideo::class);
    }

    // Students (pivot: course_students)
    public function students()
    {
        return $this->belongsToMany(
            User::class,
            'course_students',   // nama tabel pivot
            'course_id',         // FK ke courses
            'user_id'            // FK ke users
        )
        ->withTimestamps()
        ->withPivot('deleted_at')
        ->using(CourseStudentPivot::class);
    }

    
}
