<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CourseVideo extends Model
{
    use SoftDeletes;

    protected $table = 'course_videos';

    protected $fillable = [
        'course_id',
        'name',
        'path_video',
        // kolom lain...
    ];

    protected $casts = [
        'course_id' => 'integer',
        'deleted_at' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * Ambil YouTube ID dari berbagai format URL:
     * - https://www.youtube.com/watch?v=xxxx
     * - https://youtu.be/xxxx
     * - https://www.youtube.com/embed/xxxx
     */
    public function getYoutubeIdAttribute(): ?string
    {
        $url = $this->path_video;

        if (! $url) {
            return null;
        }

        // watch?v=
        if (Str::contains($url, 'v=')) {
            $id = Str::after($url, 'v=');
            return Str::before($id, '&');
        }

        // youtu.be/
        if (Str::contains($url, 'youtu.be/')) {
            $id = Str::after($url, 'youtu.be/');
            return Str::before($id, '?');
        }

        // embed/
        if (Str::contains($url, 'embed/')) {
            $id = Str::after($url, 'embed/');
            return Str::before($id, '?');
        }

        return null;
    }

    public function getEmbedUrlAttribute(): ?string
    {
        return $this->youtube_id
            ? 'https://www.youtube.com/embed/' . $this->youtube_id
            : null;
    }
}
