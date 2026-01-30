<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseStudent extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'course_students';
    protected $fillable = ['user_id','course_id'];

    public function user(){ return $this->belongsTo(User::class); }
    public function course(){ return $this->belongsTo(Course::class); }
}
