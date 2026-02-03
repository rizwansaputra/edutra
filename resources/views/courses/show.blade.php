{{-- resources/views/courses/show.blade.php --}}
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $course->name }}</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />

<style>
body{
    font-family:'Poppins',sans-serif;
    background:#eef2f5;
}

/* ================= HERO ================= */
.hero-wrapper{
    margin-top:40px;
}

.hero{
    background:url('{{ asset("assets/background/Hero-Banner.png") }}') center/cover no-repeat;
    border-radius:32px;
    padding:40px 60px 220px 60px;
    position:relative;
    overflow:hidden;
}

.navbar-nav .nav-link{
    color:white !important;
    font-weight:600;
    margin:0 18px;
}

.navbar-toggler{
    border:none;
}

/* ================= VIDEO ================= */
.video-wrapper{
    margin-top:-150px;
    position:relative;
    z-index:5;
    padding: 0px 50px 0px 50px;
}

.video-card{
    border-radius:24px;
    overflow:hidden;
}

/* ================= SIDEBAR ================= */
.video-sidebar{
    background:white;
    border-radius:24px;
    padding:25px;
}

.lesson-item{
    border-radius:50px;
    padding:12px 20px;
    font-weight:500;
    background:#f1f3f6;
    margin-bottom:12px;
    transition:.3s;
}

.lesson-item:hover{
    background:#3525B3;
    color:white;
}

.lesson-active{
    background:#3525B3;
    color:white;
}

/* ================= CONTENT BOX ================= */
.section-box{
    background:white;
    border-radius:24px;
    padding:30px;
}

/* ================= FOOTER ================= */
.footer{
    background:#F5F8FA;
    border-radius:32px;
    padding:60px;
    margin-top:80px;
}
</style>
</head>
<body>

@php
$trailer = $course->path_trailer ?: 'https://www.youtube.com/watch?v=bTqVqk7FSmY';
preg_match('/(youtu\.be\/|v=)([^&]+)/', $trailer, $matches);
$videoId = $matches[2] ?? 'bTqVqk7FSmY';
$embedUrl = "https://www.youtube.com/embed/".$videoId;
@endphp

{{-- ================= HERO ================= --}}
<div class="container hero-wrapper">
<div class="hero text-white">

<nav class="navbar navbar-expand-lg navbar-dark px-0">
<div class="container-fluid">

<a class="navbar-brand" href="{{ route('home') }}">
<img src="{{ asset('assets/logo/logo.svg') }}" height="40">
</a>

<button class="navbar-toggler" type="button"
        data-bs-toggle="collapse"
        data-bs-target="#mainNavbar">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse justify-content-center" id="mainNavbar">

<ul class="navbar-nav mx-auto text-center">
<li class="nav-item"><a class="nav-link" href="#">Home</a></li>
<li class="nav-item"><a class="nav-link" href="#">Kelas</a></li>
<li class="nav-item"><a class="nav-link" href="#">Produk Digital</a></li>
<li class="nav-item"><a class="nav-link" href="#">Stories</a></li>
</ul>

<div class="d-flex gap-2 mt-3 mt-lg-0">
<a href="#" class="btn btn-outline-light rounded-pill px-4">Login</a>
<a href="#" class="btn rounded-pill px-4"
style="background:#FF6129;color:white;">
Register
</a>
</div>

</div>
</div>
</nav>

</div>
</div>

{{-- ================= VIDEO SECTION ================= --}}
<div class="container video-wrapper">

<div class="row g-4">

<div class="col-lg-8">
<div class="ratio ratio-16x9 shadow video-card">
<iframe id="player"
src="{{ $embedUrl }}?rel=0&modestbranding=1&playsinline=1&enablejsapi=1"
allowfullscreen allow="autoplay"></iframe>
</div>
</div>

<div class="col-lg-4">
<div class="video-sidebar shadow-sm">

<h5 class="fw-bold mb-4">
{{ $course->videos->count() }} Lessons
</h5>

@foreach($course->videos as $index => $video)
<div class="lesson-item {{ $index==0 ? 'lesson-active' : '' }}">
{{ $video->name }}
</div>
@endforeach

</div>
</div>

</div>

{{-- ================= TITLE ================= --}}
<div class="mt-5">
<h2 class="fw-bold">{{ $course->name }}</h2>

<div class="d-flex gap-4 small mt-2 flex-wrap">
<span>{{ $course->category->name ?? 'Category' }}</span>
<span>{{ $course->students->count() }} students</span>
<span>Certificate</span>
</div>

@if(auth()->check() && $isSubscribed)
<a href="{{ url('/student/my-courses/'.$course->id) }}"
class="btn btn-success rounded-pill mt-3">
Lanjut Belajar
</a>
@else
<a href="{{ route('checkout.free.show', $course->slug) }}"
class="btn rounded-pill mt-3"
style="background:#FF6129;color:white;">
Checkout Course
</a>
@endif

</div>

</div>
{{-- ================= ABOUT SECTION ================= --}}
<div class="container mt-5">
    <div class="row g-4">

        <div class="col-lg-8">
            <div class="section-box shadow-sm">

                <h4 class="fw-bold mb-4">About this course</h4>

                {{-- DESKRIPSI --}}
                @if($course->about)
                  <p class="mb-4 text-muted" style="line-height:1.9;">
                        {!! nl2br(e($course->about)) !!}
                    </p>
                @else
                    <p class="text-muted mb-4">
                        Belum ada deskripsi.
                    </p>
                @endif


                {{-- KEYPOINTS --}}
                @if($course->keypoints && $course->keypoints->count())
                    <div class="row">
                        @foreach($course->keypoints as $kp)
                            <div class="col-md-6 mb-3 d-flex align-items-start">

                                <div class="me-3">
                                    <div style="
                                        width:26px;
                                        height:26px;
                                        background:#FFEEE6;
                                        border-radius:50%;
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;">
                                        <span style="color:#FF6129;font-weight:bold;">✓</span>
                                    </div>
                                </div>

                                <div style="font-weight:500;">
                                    {{ $kp->name }}
                                </div>

                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>


        {{-- TEACHER --}}
        <div class="col-lg-4">
            <div class="section-box shadow-sm">

                <h5 class="fw-bold mb-4">Teacher</h5>

                <div class="d-flex align-items-center">
                    <img src="{{ asset('assets/photo/photo1.png') }}"
                         width="55" height="55"
                         class="rounded-circle me-3">

                    <div>
                        <div class="fw-semibold">
                            {{ $course->teacher?->user?->name ?? 'Unknown' }}
                        </div>
                        <small class="text-muted">Mentor</small>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

{{-- ================= FOOTER ================= --}}
<div class="container footer">
<div class="row gy-4">

<div class="col-lg-3">
<img src="{{ asset('assets/logo/logo-black.svg') }}" height="40">
</div>

<div class="col-lg-3">
<h6 class="fw-bold mb-3">Products</h6>
<p class="text-muted small mb-1">Online Courses</p>
<p class="text-muted small mb-1">Career Guidance</p>
</div>

<div class="col-lg-3">
<h6 class="fw-bold mb-3">Company</h6>
<p class="text-muted small mb-1">About Us</p>
<p class="text-muted small mb-1">Careers</p>
</div>

<div class="col-lg-3">
<h6 class="fw-bold mb-3">Resources</h6>
<p class="text-muted small mb-1">Blog</p>
<p class="text-muted small mb-1">Help Center</p>
</div>

</div>

<hr class="my-4">

<p class="text-center small text-muted mb-0">
© 2024 Edutra. All Rights Reserved.
</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
new Plyr('#player');
});
</script>

</body>
</html>
