<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseStudentPivot extends Pivot
{
    use SoftDeletes;

    protected $table = 'course_students';
    protected $dates = ['deleted_at'];
    public $timestamps = true;
}
