{{-- resources/views/courses/show.blade.php --}}
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
  rel="stylesheet"
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
  crossorigin="anonymous"
/>

    {{-- Tailwind hasil build --}}
    <link href="{{ asset('output.css') }}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    {{-- CSS eksternal --}}
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"
    />

    <style>
        .text-white a {
    color: #ffffff !important;
}
    .text-white {
    color: #ffffff !important;
}
    .group-hover{
        color: #ffffff !important;
    }

    .group:hover .group-hover\:text-white {
    color: #ffffff;
}
    </style>
</head>
<body class="text-black font-poppins pt-10 pb-[50px]">

@php
    // --- Trailer / video embed handling ---
    $trailer = $course->path_trailer;

    // Jika belum ada trailer di DB, pakai sample bawaan
    if (! $trailer) {
        $trailer = 'https://www.youtube.com/watch?v=bTqVqk7FSmY';
    }

    // Ubah berbagai format YouTube menjadi embed URL
    $embedUrl = preg_replace(
        [
            '~https?://youtu\.be/([^?&]+)~',                          // youtu.be/xxxxx
            '~https?://(www\.)?youtube\.com/watch\?v=([^&]+)~',       // youtube.com/watch?v=xxxxx
        ],
        [
            'https://www.youtube.com/embed/$1',
            'https://www.youtube.com/embed/$2',
        ],
        $trailer
    );
@endphp

{{-- =========================
      HERO SECTION
========================= --}}
<div id="hero-section"
     class="max-w-[1200px] mx-auto w-full h-[393px] flex flex-col gap-10 pb-[50px]
            bg-[url('assets/background/Hero-Banner.png')]
            bg-center bg-no-repeat bg-cover rounded-[32px] absolute
            transform -translate-x-1/2 left-1/2 
            z-[1000] overflow-visible"> 
            {{-- overflow-visible WAJIB agar dropdown tidak terpotong --}}

    {{-- Tambahkan z-[1001] pada nav agar berada di atas background hero --}}
    {{-- NAVBAR --}}
    <nav class="flex justify-between items-center pt-6 px-[50px] relative z-20">
    <a href="{{ route('home') }}" class="shrink-0">
        <img src="{{ asset('assets/logo/logo.svg') }}" alt="logo">
    </a>

    <ul class="flex items-center gap-[30px] text-white mb-0">
        <li><a href="{{ route('home') }}" class="font-semibold no-underline text-white">Home</a></li>
        <li><a href="#Popular-Courses" class="font-semibold no-underline text-white">Kelas</a></li>
        <li><a href="#" class="font-semibold no-underline text-white">Produk Digital</a></li>
        <li><a href="#" class="font-semibold no-underline text-white">Stories</a></li>
    </ul>

    @auth
        <div class="relative flex gap-[10px] items-center">
            <div class="flex flex-col items-end justify-center leading-tight">
                <p class="font-semibold text-white mb-1">
                    Hi, {{ auth()->user()->name }}
                </p>
                <p class="p-[2px_10px] rounded-full bg-[#FF6129] font-semibold text-xs text-white text-center mb-0">
                    Student
                </p>
            </div>

            <button
                type="button"
                id="user-menu-toggle"
                class="block w-[56px] h-[56px] overflow-hidden rounded-full flex shrink-0 border border-white/40"
                aria-haspopup="true"
                aria-expanded="false"
            >
                <img src="{{ asset('assets/photo/photo5.png') }}" class="w-full h-full object-cover" alt="photo">
            </button>

            <div
                id="user-menu"
                class="hidden absolute right-0 top-full mt-3 z-[9999] flex flex-col
                       bg-white rounded-xl shadow-lg py-2 overflow-hidden"
                style="min-width: 160px;"
            >
                {{-- My Courses --}}
                <a href="{{ url('/student/my-courses') }}"
                   class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 no-underline">
                    My Courses
                </a>

                {{-- Settings --}}
                <a href="{{ url('/student/settings') }}"
                   class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 no-underline">
                    Settings
                </a>

                <form method="POST"
                      action="{{ route('filament.student.auth.logout') }}"
                      class="mt-2 pt-2 border-t border-gray-100">
                    @csrf
                    <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    @else
        <div class="flex gap-[10px] items-center">
            <a href="{{ route('filament.student.auth.login') }}"
               class="text-white font-semibold rounded-[30px] p-[16px_32px] ring-1 ring-white
                      transition-all duration-300 hover:ring-2 hover:ring-[#FF6129] no-underline">
                Login
            </a>

            <a href="{{ url('/register') }}"
               class="text-white font-semibold rounded-[30px] p-[16px_32px] bg-[#FF6129]
                      transition-all duration-300 hover:shadow-[0_10px_20px_0_#FF612980] no-underline">
                Register
            </a>
        </div>
    @endauth
</nav>

</div>
{{-- =========================
     VIDEO PLAYER + SIDEBAR
========================= --}}
<section id="video-content" class="max-w-[1100px] w-full mx-auto mt-[130px] relative z-10">
    <div class="video-player relative flex flex-nowrap gap-5">

        {{-- VIDEO PLAYER – struktur sama dengan template (Plyr yang atur ratio) --}}
        <div class="plyr__video-embed w-full overflow-hidden relative rounded-[20px]" id="player" style="width: -moz-available;">
            <iframe
            class="absolute top-0 left-0 w-full h-full"
            src="{{ $embedUrl }}?origin={{ url('/') }}&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1"
            allowfullscreen
            allow="autoplay"
        ></iframe>
        </div>

        {{-- SIDEBAR LESSONS --}}
        <div class="video-player-sidebar flex flex-col shrink-0 w-[330px] h-[470px] bg-[#F5F8FA] 
                    rounded-[20px] p-3 pb-0 overflow-y-scroll no-scrollbar relative z-0">
            <p class="font-bold text-lg text-black">
                {{ $course->videos->count() }} Lessons
            </p>
            <div class="flex flex-col gap-3">
                @forelse($course->videos as $index => $video)
                    <div class="group p-[12px_16px] flex items-center gap-[10px]
            {{ $index === 0 ? 'bg-[#3525B3]' : 'bg-[#E9EFF3]' }}
            rounded-full hover:bg-[#3525B3] transition-all duration-300">

    {{-- ICON --}}
            <div class="transition-all duration-300
                        {{ $index === 0 ? 'text-white group-hover:text-white' : 'text-black group-hover:text-white' }}">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.97 2C6.44997 2 1.96997 6.48 1.96997 12C1.96997 17.52 6.44997 22 11.97 22C17.49 22 21.97 17.52 21.97 12C21.97 6.48 17.5 2 11.97 2ZM14.97 14.23L12.07 15.9C11.71 16.11 11.31 16.21 10.92 16.21C10.52 16.21 10.13 16.11 9.76997 15.9C9.04997 15.48 8.61997 14.74 8.61997 13.9V10.55C8.61997 9.72 9.04997 8.97 9.76997 8.55C10.49 8.13 11.35 8.13 12.08 8.55L14.98 10.22C15.7 10.64 16.13 11.38 16.13 12.22C16.13 13.06 15.7 13.81 14.97 14.23Z"
                        fill="currentColor"/>
                </svg>
            </div>

            {{-- TEXT --}}
            <p class="font-semibold transition-all duration-300
                    {{ $index === 0 ? 'text-white group-hover:text-white' : 'text-black group-hover:text-white' }}">
                {{ $video->name }}
            </p>
        </div>

                @empty
                    <p class="text-sm text-gray-500">Belum ada video untuk course ini.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- =========================
     TITLE + META + TABS
========================= --}}
<section id="Video-Resources" class="mt-5">
    <div class="container px-4 mt-3" style="max-width: 1100px;">
    @if(auth()->check() && $isSubscribed)
        {{-- ✅ SUDAH SUBSCRIBE --}}
        <a href="{{ url('/student/my-courses/' . $course->id) }}"
           class="btn btn-success fw-semibold rounded-pill px-4 py-2">
            Lanjut Belajar
        </a>
    @else
        {{-- ❌ BELUM SUBSCRIBE --}}
        <a href="{{ route('checkout.free.show', $course->slug) }}"
           class="btn btn-warning fw-semibold rounded-pill px-4 py-2"
           style="background-color:#FF6129; border-color:#FF6129; color:white;">
            Checkout Course
        </a>
    @endif
</div>

   

    {{-- TITLE + META --}}
        <div class="container px-4" style="max-width: 1100px;">
        <h1 class="title fw-bold" style="font-size:30px; line-height:45px;">
            {{ $course->name }}
        </h1>

        <div class="d-flex flex-wrap align-items-center gap-3 small mt-2">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('assets/icon/crown.svg') }}" alt="icon">
                <p class="mb-0 fw-semibold">
                    {{ $course->category->name ?? 'Uncategorized' }}
                </p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('assets/icon/award-outline.svg') }}" alt="icon">
                <p class="mb-0 fw-semibold">Certificate</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('assets/icon/profile-2user.svg') }}" alt="icon">
                <p class="mb-0 fw-semibold">
                    {{ $course->students_count ?? 0 }} students
                </p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('assets/icon/brifecase-tick.svg') }}" alt="icon">
                <p class="mb-0 fw-semibold">Job-Guarantee</p>
            </div>
        </div>

       
        {{-- TOMBOL CHECKOUT FREE --}}
        {{-- <div class="mt-3 d-flex gap-2 flex-wrap">
            @auth
                <a href="{{ route('checkout.free.show', $course) }}"
                class="btn btn-warning fw-semibold rounded-pill px-4 py-2"
                style="background-color:#FF6129; border-color:#FF6129; color:white;">
                    Activate Free Plan
                </a>
            @else
                <a href="{{ route('filament.admin.auth.login') }}"
                class="btn btn-outline-primary fw-semibold rounded-pill px-4 py-2">
                    Login to Activate Free Plan
                </a>
            @endauth
        </div> --}}
    </div>


    {{-- TAB NAV (Bootstrap Tabs) --}}
    <div class="container px-4 mt-4" style="max-width: 1100px;">
        <ul class="nav nav-tabs overflow-auto flex-nowrap border-0" style="padding-bottom: 1px !important;padding-top: 30px;">
            <li class="nav-item">
                <button
                    class="nav-link active fw-semibold"
                    id="tab-about-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#tab-about"
                    type="button"
                    role="tab"
                >
                    About
                </button>
            </li>
            <li class="nav-item">
                <button
                    class="nav-link fw-semibold"
                    id="tab-resources-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#tab-resources"
                    type="button"
                    role="tab"
                >
                    Resources
                </button>
            </li>
            <li class="nav-item">
                <button
                    class="nav-link fw-semibold"
                    id="tab-reviews-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#tab-reviews"
                    type="button"
                    role="tab"
                >
                    Reviews
                </button>
            </li>
            <li class="nav-item">
                <button
                    class="nav-link fw-semibold"
                    id="tab-discussions-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#tab-discussions"
                    type="button"
                    role="tab"
                >
                    Discussions
                </button>
            </li>
            <li class="nav-item">
                <button
                    class="nav-link fw-semibold"
                    id="tab-rewards-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#tab-rewards"
                    type="button"
                    role="tab"
                >
                    Rewards
                </button>
            </li>
        </ul>
    </div>

    {{-- TAB CONTENT + SIDEBAR --}}
    <div class="bg-[#F5F8FA] py-5 mt-0">
        <div class="container px-4" style="max-width: 1100px;">
            <div class="row g-4">
                {{-- LEFT: TAB CONTENTS (2/3 kolom) --}}
                <div class="col-12 col-lg-8">
                    <div class="tab-content">

                        {{-- ABOUT TAB --}}
                        <div class="tab-pane fade show active" id="tab-about" role="tabpanel" aria-labelledby="tab-about-tab" >
                            <div class="d-flex flex-column gap-3" >
                                <h3 class="fw-bold fs-4">About this course</h3>

                                @if($course->about)
                                    <p class="fw-medium" style="line-height:30px; white-space:pre-line;">
                                        {{ $course->about }}
                                    </p>
                                @else
                                    <p class="fw-medium text-muted" style="line-height:30px;">
                                        Belum ada deskripsi untuk course ini.
                                    </p>
                                @endif

                                @if($course->keypoints->count())
                                    <div class="row g-3 mt-2">
                                        @foreach($course->keypoints as $kp)
                                            <div class="col-12 col-sm-6 d-flex align-items-start gap-2">
                                                <div style="width:24px; height:24px; flex-shrink:0;">
                                                    <img src="{{ asset('assets/icon/tick-circle.svg') }}" alt="icon" class="img-fluid">
                                                </div>
                                                <p class="mb-0 fw-medium" style="line-height:30px;">
                                                    {{ $kp->name }}
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- RESOURCES TAB --}}
                        <div class="tab-pane fade" id="tab-resources" role="tabpanel" aria-labelledby="tab-resources-tab">
                            <h3 class="fw-bold fs-4 mb-3">Resources</h3>
                            <p class="fw-medium" style="line-height:30px;">
                                Belum ada resources tambahan untuk course ini.
                            </p>
                        </div>

                        {{-- REVIEWS TAB --}}
                        <div class="tab-pane fade" id="tab-reviews" role="tabpanel" aria-labelledby="tab-reviews-tab">
                            <h3 class="fw-bold fs-4 mb-3">Reviews</h3>
                            <p class="fw-medium" style="line-height:30px;">
                                Belum ada review untuk course ini.
                            </p>
                        </div>

                        {{-- DISCUSSIONS TAB --}}
                        <div class="tab-pane fade" id="tab-discussions" role="tabpanel" aria-labelledby="tab-discussions-tab">
                            <h3 class="fw-bold fs-4 mb-3">Discussions</h3>
                            <p class="fw-medium" style="line-height:30px;">
                                Fitur diskusi belum tersedia.
                            </p>
                        </div>

                        {{-- REWARDS TAB --}}
                        <div class="tab-pane fade" id="tab-rewards" role="tabpanel" aria-labelledby="tab-rewards-tab">
                            <h3 class="fw-bold fs-4 mb-3">Rewards</h3>
                            <p class="fw-medium" style="line-height:30px;">
                                Rewards course ini belum diatur.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- RIGHT: MENTOR + BADGES (1/3 kolom) --}}
                <div class="col-12 col-lg-4">
                    <div class="d-flex flex-column gap-3">

                        {{-- Teacher --}}
                        <div class="bg-white rounded-4 p-4 d-flex flex-column gap-3">
                            <p class="fw-bold fs-5 mb-0">Teacher</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle overflow-hidden" style="width:50px; height:50px;">
                                        <img src="{{ asset('assets/photo/photo1.png') }}"
                                             class="w-100 h-100 object-cover"
                                             alt="photo">
                                    </div>
                                    <div class="d-flex flex-column gap-1">
                                        <p class="fw-semibold mb-0">
                                            {{ $course->teacher?->user?->name ?? 'Unknown Teacher' }}
                                        </p>
                                        <p class="mb-0 small text-muted">Mentor</p>
                                    </div>
                                </div>
                                <a href="#"
                                   class="px-3 py-1 rounded-pill text-white fw-semibold"
                                   style="font-size:12px; background-color:#FF6129;">
                                    Follow
                                </a>
                            </div>
                        </div>

                        {{-- Unlock Badges --}}
                        <div class="bg-white rounded-4 p-4 d-flex flex-column gap-3">
                            <p class="fw-bold fs-5 mb-0">Unlock Badges</p>

                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle overflow-hidden" style="width:50px; height:50px;">
                                    <img src="{{ asset('assets/icon/Group 7.svg') }}" class="w-100 h-100 object-cover" alt="icon">
                                </div>
                                <div class="d-flex flex-column gap-1">
                                    <span class="fw-semibold">Spirit of Learning</span>
                                    <span class="small text-muted">18,393 earned</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle overflow-hidden" style="width:50px; height:50px;">
                                    <img src="{{ asset('assets/icon/Group 7-1.svg') }}" class="w-100 h-100 object-cover" alt="icon">
                                </div>
                                <div class="d-flex flex-column gap-1">
                                    <span class="fw-semibold">Everyday New</span>
                                    <span class="small text-muted">6,392 earned</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle overflow-hidden" style="width:50px; height:50px;">
                                    <img src="{{ asset('assets/icon/Group 7-2.svg') }}" class="w-100 h-100 object-cover" alt="icon">
                                </div>
                                <div class="d-flex flex-column gap-1">
                                    <span class="fw-semibold">Quick Learner Pro</span>
                                    <span class="small text-muted">44 earned</span>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div> {{-- row --}}
        </div> {{-- container --}}
    </div>
</section>

{{-- =========================
     FAQ (statis)
========================= --}}
<section id="FAQ" class="max-w-[1200px] mx-auto flex flex-col py-[70px] px-[100px]">
    <div class="flex flex-col lg:flex-row justify-between items-start gap-10">
        <div class="flex flex-col gap-[30px]">
            
            <div class="flex flex-col">
                <h2 class="font-bold text-[36px] leading-[52px]">Get Your Answers</h2>
                <p class="text-lg text-[#475466]">It’s time to upgrade skills without limits!</p>
            </div>
            <a href="#"
               class="text-white font-semibold rounded-[30px] p-[16px_32px] bg-[#FF6129]
                      transition-all duration-300 hover:shadow-[0_10px_20px_0_#FF612980] w-fit">
                Contact Our Sales
            </a>
        </div>
        <div class="flex flex-col gap-[30px] w-full lg:w-[552px] shrink-0">
            @for($i = 1; $i <= 4; $i++)
                <div class="flex flex-col p-3 rounded-2xl bg-[#FFF8F4] has-[.hide]:bg-transparent
                            border-t-4 border-[#FF6129] has-[.hide]:border-0 w-full">
                    <button class="accordion-button flex justify-between gap-1 items-center"
                            data-accordion="accordion-faq-{{ $i }}">
                        <span class="font-semibold text-lg text-left">
                            @switch($i)
                                @case(1) Can beginner join the course? @break
                                @case(2) How long does the implementation take? @break
                                @case(3) Do you provide the job-guarantee program? @break
                                @case(4) How to issue all course certificates? @break
                            @endswitch
                        </span>
                        <div class="arrow w-9 h-9 flex shrink-0">
                            <img src="{{ asset('assets/icon/add.svg') }}" alt="icon">
                        </div>
                    </button>
                    <div id="accordion-faq-{{ $i }}" class="accordion-content hide">
                        <p class="leading-[30px] text-[#475466] pt-[10px]">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Molestiae itaque facere ipsum animi sunt iure!
                        </p>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>


{{-- =========================
     SCRIPTS
========================= --}}
<script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous">
</script>

<script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script src="{{ asset('main.js') }}"></script>

<script>
    // Tab handler (About, Resources, dll)
    function openPage(pageName, elmnt) {
        const tabcontent = document.getElementsByClassName("tabcontent");
        for (let i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        const tablinks = document.getElementsByClassName("tablink");
        for (let i = 0; i < tablinks.length; i++) {
            tablinks[i].classList.remove('text-[#FF6129]');
        }

        document.getElementById(pageName).style.display = "block";
        elmnt.classList.add('text-[#FF6129]');
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Buka default tab
        const defaultOpen = document.getElementById("defaultOpen");
        if (defaultOpen) {
            defaultOpen.click();
        }

        // Init Plyr
        if (window.Plyr) {
            new Plyr('#player');
        }

        // Init Fancybox
        if (window.Fancybox) {
            Fancybox.bind("[data-fancybox='gallery']", {});
        }
    });
</script>
<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
  crossorigin="anonymous"
></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('user-menu-toggle');
        const menu   = document.getElementById('user-menu');

        if (toggle && menu) {
            // Klik avatar => toggle dropdown
            toggle.addEventListener('click', function (e) {
                e.stopPropagation(); // supaya klik di avatar nggak ikut nutup menu
                menu.classList.toggle('hidden');
            });

            // Klik di luar => tutup dropdown
            document.addEventListener('click', function () {
                if (!menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                }
            });

            // Biar klik di dalam menu tidak menutup dropdown
            menu.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        }
    });
</script>


</body>
</html>
