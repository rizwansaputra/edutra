<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('output.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"
    />
</head>
<body class="text-black font-poppins pt-10 pb-[50px]">
@php
    use Illuminate\Support\Str;

    // trailer handling (YOUTUBE / FILE)
    $trailer  = $course->path_trailer ?? null;
    $embedUrl = null;
    $isYoutube = false;

    if ($trailer) {
        $isYoutube = Str::contains($trailer, ['youtube.com', 'youtu.be']);

        if ($isYoutube) {
            $embedUrl = preg_replace(
                [
                    '~https?://youtu\.be/([^?&]+)~',
                    '~https?://www\.youtube\.com/watch\?v=([^&]+)~'
                ],
                [
                    'https://www.youtube.com/embed/$1',
                    'https://www.youtube.com/embed/$1'
                ],
                $trailer
            );
        }
    }

    // thumbnail fallback untuk portfolio / thumbnail course kalau mau
@endphp

    {{-- HERO SECTION --}}
    <div id="hero-section"
         class="max-w-[1200px] mx-auto w-full h-[393px] flex flex-col gap-10 pb-[50px]
                bg-[url('{{ asset('assets/background/Hero-Banner.png') }}')]
                bg-center bg-no-repeat bg-cover rounded-[32px] overflow-hidden
                absolute transform -translate-x-1/2 left-1/2">
        <nav class="flex justify-between items-center pt-6 px-[50px]">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/logo/logo.png') }}" alt="logo">
            </a>
            <ul class="flex items-center gap-[30px] text-white">
                <li>
                    <a href="{{ route('home') }}" class="font-semibold">Home</a>
                </li>
                <li>
                    <a href="#" class="font-semibold">Pricing</a>
                </li>
                <li>
                    <a href="#" class="font-semibold">Benefits</a>
                </li>
                <li>
                    <a href="#" class="font-semibold">Stories</a>
                </li>
            </ul>
            <div class="flex gap-[10px] items-center">
                <div class="flex flex-col items-end justify-center">
                    <p class="font-semibold text-white">
                        Hi, {{ auth()->check() ? auth()->user()->name : 'Guest' }}
                    </p>
                    <p class="p-[2px_10px] rounded-full bg-[#FF6129] font-semibold text-xs text-white text-center">
                        PRO
                    </p>
                </div>
                <div class="w-[56px] h-[56px] overflow-hidden rounded-full flex shrink-0">
                    <img src="{{ asset('assets/photo/photo5.png') }}" class="w-full h-full object-cover" alt="photo">
                </div>
            </div>
        </nav>
    </div>

    {{-- VIDEO CONTENT --}}
    <section id="video-content" class="max-w-[1100px] w-full mx-auto mt-[130px]">
        <div class="video-player relative flex flex-nowrap gap-5">
            <div class="plyr__video-embed w-full overflow-hidden relative rounded-[20px]" id="player">
                @if($trailer && $isYoutube && $embedUrl)
                    <iframe
                        src="{{ $embedUrl }}?origin={{ url('/') }}&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1"
                        allowfullscreen
                        allowtransparency
                        allow="autoplay"
                    ></iframe>
                @elseif($trailer)
                    {{-- kalau path_trailer file video --}}
                    <video class="w-full h-full" controls>
                        <source
                            src="{{ Str::startsWith($trailer, ['http','https','/storage']) ? $trailer : asset('storage/'.$trailer) }}"
                            type="video/mp4">
                    </video>
                @else
                    {{-- fallback: kalau belum ada trailer --}}
                    @php
                        $thumbPath = $course->thumbnail ?? 'assets/thumbnail/thumbnail-1.png';
                        $thumbUrl  = Str::startsWith($thumbPath, ['http','https'])
                            ? $thumbPath
                            : asset($thumbPath);
                    @endphp
                    <img src="{{ $thumbUrl }}" class="w-full h-full object-cover" alt="{{ $course->name }}">
                @endif
            </div>

            {{-- SIDEBAR VIDEO / LESSON LIST --}}
            <div class="video-player-sidebar flex flex-col shrink-0 w-[330px] h-[470px] bg-[#F5F8FA] rounded-[20px] p-5 gap-5 pb-0 overflow-y-scroll no-scrollbar">
                <p class="font-bold text-lg text-black">
                    {{ $course->videos->count() }} Lessons
                </p>
                <div class="flex flex-col gap-3">
                    @forelse($course->videos as $index => $video)
                        <div class="group p-[12px_16px] flex items-center gap-[10px]
                                    {{ $index === 0 ? 'bg-[#3525B3] text-white' : 'bg-[#E9EFF3]' }}
                                    rounded-full hover:bg-[#3525B3] transition-all duration-300">
                            <div class="{{ $index === 0 ? 'text-white' : 'text-black' }} group-hover:text-white transition-all duration-300">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.97 2C6.44997 2 1.96997 6.48 1.96997 12C1.96997 17.52 6.44997 22 11.97 22C17.49 22 21.97 17.52 21.97 12C21.97 6.48 17.5 2 11.97 2ZM14.97 14.23L12.07 15.9C11.71 16.11 11.31 16.21 10.92 16.21C10.52 16.21 10.13 16.11 9.76997 15.9C9.04997 15.48 8.61997 14.74 8.61997 13.9V10.55C8.61997 9.72 9.04997 8.97 9.76997 8.55C10.49 8.13 11.35 8.13 12.08 8.55L14.98 10.22C15.7 10.64 16.13 11.38 16.13 12.22C16.13 13.06 15.7 13.81 14.97 14.23Z"
                                          fill="currentColor"/>
                                </svg>
                            </div>
                            <p class="font-semibold group-hover:text-white transition-all duration-300">
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

    {{-- VIDEO RESOURCES / TITLE + META --}}
    <section id="Video-Resources" class="flex flex-col mt-5">
        <div class="max-w-[1100px] w-full mx-auto flex flex-col gap-3">
            <h1 class="title font-extrabold text-[30px] leading-[45px]">
                {{ $course->name }}
            </h1>
            <div class="flex flex-wrap items-center gap-5">
                <div class="flex items-center gap-[6px]">
                    <div>
                        <img src="{{ asset('assets/icon/crown.svg') }}" alt="icon">
                    </div>
                    <p class="font-semibold">
                        {{ $course->category->name ?? 'Uncategorized' }}
                    </p>
                </div>
                <div class="flex items-center gap-[6px]">
                    <div>
                        <img src="{{ asset('assets/icon/award-outline.svg') }}" alt="icon">
                    </div>
                    <p class="font-semibold">Certificate</p>
                </div>
                <div class="flex items-center gap-[6px]">
                    <div>
                        <img src="{{ asset('assets/icon/profile-2user.svg') }}" alt="icon">
                    </div>
                    <p class="font-semibold">
                        {{ $course->students_count ?? 0 }} students
                    </p>
                </div>
                <div class="flex items-center gap-[6px]">
                    <div>
                        <img src="{{ asset('assets/icon/brifecase-tick.svg') }}" alt="icon">
                    </div>
                    <p class="font-semibold">Job-Guarantee</p>
                </div>
            </div>
        </div>

        {{-- TAB NAV --}}
        <div class="max-w-[1100px] w-full mx-auto mt-10 tablink-container flex gap-3 px-4 sm:p-0 no-scrollbar overflow-x-scroll">
            <div class="tablink font-semibold text-lg h-[47px] transition-all duration-300 cursor-pointer hover:text-[#FF6129]"
                 onclick="openPage('About', this)" id="defaultOpen">
                About
            </div>
            <div class="tablink font-semibold text-lg h-[47px] transition-all duration-300 cursor-pointer hover:text-[#FF6129]"
                 onclick="openPage('Resources', this)">
                Resources
            </div>
            <div class="tablink font-semibold text-lg h-[47px] transition-all duration-300 cursor-pointer hover:text-[#FF6129]"
                 onclick="openPage('Reviews', this)">
                Reviews
            </div>
            <div class="tablink font-semibold text-lg h-[47px] transition-all duration-300 cursor-pointer hover:text-[#FF6129]"
                 onclick="openPage('Discussions', this)">
                Discussions
            </div>
            <div class="tablink font-semibold text-lg h-[47px] transition-all duration-300 cursor-pointer hover:text-[#FF6129]"
                 onclick="openPage('Rewards', this)">
                Rewards
            </div>
        </div>

        {{-- TAB CONTENT + MENTOR + PORTFOLIO --}}
        <div class="bg-[#F5F8FA] py-[50px]">
            <div class="max-w-[1100px] w-full mx-auto flex flex-col gap-[70px]">
                <div class="flex flex-col lg:flex-row gap-[50px]">
                    {{-- TAB CONTENTS --}}
                    <div class="tabs-container w-full lg:w-[700px] flex shrink-0">
                        {{-- ABOUT TAB --}}
                        <div id="About" class="tabcontent hidden">
                            <div class="flex flex-col gap-5 w-full lg:w-[700px] shrink-0">
                                <h3 class="font-bold text-2xl">Grow Your Career</h3>
                                <p class="font-medium leading-[30px]">
                                    Pada kelas ini kita akan belajar bersama dengan mentor berpengalaman dalam membangun sebuah website dengan studi kasus ujian online (computer based test) yang dapat membantu guru atau manager dalam menilai pengetahuan dari setiap student dan karyawan mereka.
                                </p>
                                <p class="font-medium leading-[30px]">
                                    Kita akan menggunakan framework php popular yaitu adalah laravel sehingga proses pengembangan website CBT menjadi lebih cepat dan mudah diperbesar bersama dengan developer/programmer lainnya suatu saat nanti. <br>
                                    Projek pada kursus online ini nanti akan terbagi oleh dua user role yaitu teacher/manager dan student/karyawan, kita akan membataskan beberapa fitur sehingga hanya bisa diakses oleh setiap role tersebut (bagus untuk user experience).
                                </p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-[30px] gap-y-5">
                                    <div class="benefit-card flex items-center gap-3">
                                        <div class="w-6 h-6 flex shrink-0">
                                            <img src="{{ asset('assets/icon/tick-circle.svg') }}" alt="icon">
                                        </div>
                                        <p class="font-medium leading-[30px]">
                                            Dolor si amet exercise better garrer axia certificate guarantee job
                                        </p>
                                    </div>
                                    <div class="benefit-card flex items-center gap-3">
                                        <div class="w-6 h-6 flex shrink-0">
                                            <img src="{{ asset('assets/icon/tick-circle.svg') }}" alt="icon">
                                        </div>
                                        <p class="font-medium leading-[30px]">
                                            Dolor si amet exercise better garrer axia certificate guarantee job
                                        </p>
                                    </div>
                                    <div class="benefit-card flex items-center gap-3">
                                        <div class="w-6 h-6 flex shrink-0">
                                            <img src="{{ asset('assets/icon/tick-circle.svg') }}" alt="icon">
                                        </div>
                                        <p class="font-medium leading-[30px]">
                                            Dolor si amet exercise better garrer axia certificate guarantee job
                                        </p>
                                    </div>
                                    <div class="benefit-card flex items-center gap-3">
                                        <div class="w-6 h-6 flex shrink-0">
                                            <img src="{{ asset('assets/icon/tick-circle.svg') }}" alt="icon">
                                        </div>
                                        <p class="font-medium leading-[30px]">
                                            Dolor si amet exercise better garrer axia certificate guarantee job
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- RESOURCES TAB --}}
                        <div id="Resources" class="tabcontent hidden">
                            <div class="flex flex-col gap-5 w-full lg:w-[700px] shrink-0">
                                <h3 class="font-bold text-2xl">Resources</h3>
                                <p class="font-medium leading-[30px]">
                                    Belum ada resources tambahan untuk course ini.
                                </p>
                            </div>
                        </div>

                        {{-- REVIEWS TAB --}}
                        <div id="Reviews" class="tabcontent hidden">
                            <div class="flex flex-col gap-5 w-full lg:w-[700px] shrink-0">
                                <h3 class="font-bold text-2xl">Reviews</h3>
                                <p class="font-medium leading-[30px]">
                                    Belum ada review untuk course ini.
                                </p>
                            </div>
                        </div>

                        {{-- DISCUSSIONS TAB --}}
                        <div id="Discussions" class="tabcontent hidden">
                            <div class="flex flex-col gap-5 w-full lg:w-[700px] shrink-0">
                                <h3 class="font-bold text-2xl">Discussions</h3>
                                <p class="font-medium leading-[30px]">
                                    Fitur diskusi belum tersedia.
                                </p>
                            </div>
                        </div>

                        {{-- REWARDS TAB --}}
                        <div id="Rewards" class="tabcontent hidden">
                            <div class="flex flex-col gap-5 w-full lg:w-[700px] shrink-0">
                                <h3 class="font-bold text-2xl">Rewards</h3>
                                <p class="font-medium leading-[30px]">
                                    Rewards untuk course ini belum diatur.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- MENTOR + BADGES --}}
                    <div class="mentor-sidebar flex flex-col gap-[30px] w-full">
                        <div class="mentor-info bg-white flex flex-col gap-4 rounded-2xl p-5">
                            <p class="font-bold text-lg text-left w-full">Teacher</p>
                            <div class="flex items-center justify-between w-full">
                                <div class="flex items-center gap-3">
                                    <div class="w-[50px] h-[50px] flex shrink-0 rounded-full overflow-hidden">
                                        <img src="{{ asset('assets/photo/photo1.png') }}" class="w-full h-full object-cover" alt="photo">
                                    </div>
                                    <div class="flex flex-col gap-[2px]">
                                        <p class="font-semibold">
                                            {{ $course->teacher?->user?->name ?? 'Unknown Teacher' }}
                                        </p>
                                        <p class="text-sm text-[#6D7786]">Product Manager</p>
                                    </div>
                                </div>
                                <a href="#"
                                   class="p-[4px_12px] rounded-full bg-[#FF6129] font-semibold text-xs text-white text-center">
                                    Follow
                                </a>
                            </div>
                        </div>
                        <div class="bg-white flex flex-col gap-5 rounded-2xl p-5">
                            <p class="font-bold text-lg text-left w-full">Unlock Badges</p>

                            <div class="flex items-center gap-3">
                                <div class="w-[50px] h-[50px] flex shrink-0 rounded-full overflow-hidden">
                                    <img src="{{ asset('assets/icon/Group 7.svg') }}" class="w-full h-full object-cover" alt="icon">
                                </div>
                                <div class="flex flex-col gap-[2px]">
                                    <div class="font-semibold">Spirit of Learning</div>
                                    <p class="text-sm text-[#6D7786]">18,393 earned</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-[50px] h-[50px] flex shrink-0 rounded-full overflow-hidden">
                                    <img src="{{ asset('assets/icon/Group 7-1.svg') }}" class="w-full h-full object-cover" alt="icon">
                                </div>
                                <div class="flex flex-col gap-[2px]">
                                    <div class="font-semibold">Everyday New</div>
                                    <p class="text-sm text-[#6D7786]">6,392 earned</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-[50px] h-[50px] flex shrink-0 rounded-full overflow-hidden">
                                    <img src="{{ asset('assets/icon/Group 7-2.svg') }}" class="w-full h-full object-cover" alt="icon">
                                </div>
                                <div class="flex flex-col gap-[2px]">
                                    <div class="font-semibold">Quick Learner Pro</div>
                                    <p class="text-sm text-[#6D7786]">44 earned</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- STUDENTS PORTFOLIO --}}
                <div id="Screenshots" class="flex flex-col gap-3">
                    <h3 class="title-section font-bold text-xl leading-[30px]">Students Portfolio</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        <div class="rounded-[20px] overflow-hidden w-full h-[200px] hover:shadow-[0_10px_20px_0_#0D051D20]
                                    transition-all duration-300"
                             data-src="{{ asset('assets/thumbnail/image.png') }}"
                             data-fancybox="gallery"
                             data-caption="Caption #1">
                            <img src="{{ asset('assets/thumbnail/image.png') }}" class="object-cover h-full w-full" alt="image">
                        </div>
                        <div class="rounded-[20px] overflow-hidden w-full h-[200px] hover:shadow-[0_10px_20px_0_#0D051D20]
                                    transition-all duration-300"
                             data-src="{{ asset('assets/thumbnail/image-1.png') }}"
                             data-fancybox="gallery"
                             data-caption="Caption #2">
                            <img src="{{ asset('assets/thumbnail/image-1.png') }}" class="object-cover h-full w-full" alt="image">
                        </div>
                        <div class="rounded-[20px] overflow-hidden w-full h-[200px] hover:shadow-[0_10px_20px_0_#0D051D20]
                                    transition-all duration-300"
                             data-src="{{ asset('assets/thumbnail/image-2.png') }}"
                             data-fancybox="gallery"
                             data-caption="Caption #3">
                            <img src="{{ asset('assets/thumbnail/image-2.png') }}" class="object-cover h-full w-full" alt="image">
                        </div>
                        <div class="rounded-[20px] overflow-hidden w-full h-[200px] hover:shadow-[0_10px_20px_0_#0D051D20]
                                    transition-all duration-300"
                             data-src="{{ asset('assets/thumbnail/image-3.png') }}"
                             data-fancybox="gallery"
                             data-caption="Caption #4">
                            <img src="{{ asset('assets/thumbnail/image-3.png') }}" class="object-cover h-full w-full" alt="image">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section id="FAQ" class="max-w-[1200px] mx-auto flex flex-col py-[70px] px-[100px]">
        <div class="flex flex-col lg:flex-row justify-between items-start gap-10">
            <div class="flex flex-col gap-[30px]">
                <div class="gradient-badge w-fit p-[8px_16px] rounded-full border border-[#FED6AD] flex items-center gap-[6px]">
                    <div>
                        <img src="{{ asset('assets/icon/medal-star.svg') }}" alt="icon">
                    </div>
                    <p class="font-medium text-sm text-[#FF6129]">Grow Your Career</p>
                </div>
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
                    <div class="flex flex-col p-5 rounded-2xl bg-[#FFF8F4] has-[.hide]:bg-transparent
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
                                @if($i === 1)
                                    Yes, we have provided a variety range of course from beginner to intermediate level to prepare your next big career,
                                @elseif($i === 2)
                                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolore placeat ut nostrum aperiam mollitia tempora aliquam perferendis explicabo eligendi commodi.
                                @else
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae itaque facere ipsum animi sunt iure!
                                @endif
                            </p>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="max-w-[1200px] mx-auto flex flex-col pt-[70px] pb-[50px] px-[100px] gap-[50px] bg-[#F5F8FA] rounded-[32px]">
        <div class="flex flex-col md:flex-row justify-between gap-10">
            <a href="{{ route('home') }}">
                <div>
                    <img src="{{ asset('assets/logo/logo-black.svg') }}" alt="logo">
                </div>
            </a>
            <div class="flex flex-col gap-5">
                <p class="font-semibold text-lg">Products</p>
                <ul class="flex flex-col gap-[14px]">
                    <li><a href="#" class="text-[#6D7786]">Online Courses</a></li>
                    <li><a href="#" class="text-[#6D7786]">Career Guidance</a></li>
                    <li><a href="#" class="text-[#6D7786]">Expert Handbook</a></li>
                    <li><a href="#" class="text-[#6D7786]">Interview Simulations</a></li>
                </ul>
            </div>
            <div class="flex flex-col gap-5">
                <p class="font-semibold text-lg">Company</p>
                <ul class="flex flex-col gap-[14px]">
                    <li><a href="#" class="text-[#6D7786]">About Us</a></li>
                    <li><a href="#" class="text-[#6D7786]">Media Press</a></li>
                    <li class="flex items-center gap-[10px]">
                        <a href="#" class="text-[#6D7786]">Careers</a>
                        <div class="gradient-badge w-fit p-[6px_10px] rounded-full border border-[#FED6AD] flex items-center">
                            <p class="font-medium text-xs text-[#FF6129]">We’re Hiring</p>
                        </div>
                    </li>
                    <li><a href="#" class="text-[#6D7786]">Developer APIs</a></li>
                </ul>
            </div>
            <div class="flex flex-col gap-5">
                <p class="font-semibold text-lg">Resources</p>
                <ul class="flex flex-col gap-[14px]">
                    <li><a href="#" class="text-[#6D7786]">Blog</a></li>
                    <li><a href="#" class="text-[#6D7786]">FAQ</a></li>
                    <li><a href="#" class="text-[#6D7786]">Help Center</a></li>
                    <li><a href="#" class="text-[#6D7786]">Terms & Conditions</a></li>
                </ul>
            </div>
        </div>
        <div class="w-full h-[51px] flex items-end border-t border-[#E7EEF2] mt-6">
            <p class="mx-auto text-sm text-[#6D7786] -tracking-[2%]">
                All Rights Reserved {{ date('Y') }}
            </p>
        </div>
    </footer>

    <!-- JavaScript -->
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous">
    </script>

    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>

    <script src="{{ asset('main.js') }}"></script>

    <script>
        // fallback tab JS (kalau di main.js belum ada)
        function openPage(pageName, elmnt) {
            const tabcontent = document.getElementsByClassName("tabcontent");
            for (let i = 0; i < tabcontent.length; i++) {
                tabcontent[i].classList.add("hidden");
            }

            const tablinks = document.getElementsByClassName("tablink");
            for (let i = 0; i < tablinks.length; i++) {
                tablinks[i].classList.remove("text-[#FF6129]");
            }

            const target = document.getElementById(pageName);
            if (target) {
                target.classList.remove("hidden");
            }
            if (elmnt) {
                elmnt.classList.add("text-[#FF6129]");
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const defaultOpen = document.getElementById("defaultOpen");
            if (defaultOpen) {
                defaultOpen.click();
            }

            if (window.Plyr) {
                new Plyr('#player');
            }

            if (window.Fancybox) {
                Fancybox.bind("[data-fancybox='gallery']", {});
            }
        });
    </script>
</body>
</html>
