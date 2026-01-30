<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('output.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
</head>

<body class="text-black font-poppins pt-10 pb-[50px] bg-[#F5F8FA]">

{{-- HERO SECTION (FIX: dropdown tidak ke-clip) --}}
<div id="hero-section"
     style="background-image: url('{{ asset('assets/background/Hero-Banner.png') }}');"
     class="relative max-w-[1200px] mx-auto w-full flex flex-col gap-10
            bg-center bg-no-repeat bg-cover rounded-[32px] overflow-visible">

    {{-- overlay agar menu putih selalu terlihat --}}
    <div class="absolute inset-0 bg-black/30 rounded-[32px] pointer-events-none"></div>

    {{-- NAVBAR --}}
    <nav class="flex justify-between items-center pt-6 pb-6 px-[50px] relative z-20">
        <a href="{{ route('home') }}">
            <img src="{{ asset('assets/logo/logo.svg') }}" alt="logo">
        </a>

        <ul class="flex items-center gap-[30px] text-white">
            <li><a href="{{ route('home') }}" class="font-semibold">Home</a></li>
            <li><a href="#" class="font-semibold">Pricing</a></li>
            <li><a href="#" class="font-semibold">Benefits</a></li>
            <li><a href="#" class="font-semibold">Stories</a></li>
        </ul>

        @auth
        <div class="flex gap-[10px] items-center">
            <div class="flex flex-col items-end justify-center">
                <p class="font-semibold text-white">Hi, {{ auth()->user()->name }}</p>
            </div>

            <div class="relative">
                <button id="user-menu-toggle"
                        class="w-[56px] h-[56px] overflow-hidden rounded-full flex shrink-0 border border-white/20">
                    <img src="{{ asset('assets/photo/photo5.png') }}" class="w-full h-full object-cover" alt="photo">
                </button>

                <div id="user-menu"
                     style="width: 130px; padding: 11px 10px 10px 5px;"
                     class="hidden absolute right-0 top-[70px] flex flex-col w-48
                            bg-white rounded-2xl shadow-xl py-2 z-50 overflow-hidden text-black">
                    <a href="{{ route('my-courses.index') }}"
                       class="px-4 py-3 text-sm hover:bg-gray-50 transition">
                        My Courses
                    </a>

                    <a href="{{ route('settings.edit') }}"
                       class="px-4 py-3 text-sm text-[#FF6129] font-bold">
                        Settings
                    </a>

                    <form method="POST" action="{{ url('/logout') }}" class="border-t border-gray-100">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endauth
    </nav>

    {{-- HERO TITLE (kalau ada konten hero, taruh di sini) --}}
</div>

{{-- CONTENT SECTION --}}
<section class="max-w-[1200px] mx-auto flex flex-col py-[50px] px-[50px] gap-[30px] bg-[#F5F8FA]">

    @if(session('success'))
        <div class="p-4 rounded-2xl bg-green-50 border border-green-100 text-green-800 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col gap-2">
        <h2 class="font-bold text-[40px] leading-[60px]">My Courses</h2>
        <p class="text-[#6D7786] text-lg -tracking-[2%]">
            Upgrade terus ilmu dan pengalaman terbaru kamu di bidang teknologi
        </p>
    </div>

    <form method="GET" action="{{ route('my-courses.index') }}" class="w-full flex items-center gap-4">
        {{-- SEARCH --}}
        <div class="flex-1 min-w-0">
            <div class="h-[56px] w-full flex items-center bg-white rounded-[30px]
                        pl-6 pr-5 gap-3 ring-1 ring-[#DADEE4]
                        focus-within:ring-2 focus-within:ring-[#FF6129]
                        transition">

                <div class="flex items-center justify-center shrink-0 w-5 h-5 ml-0">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         style="width:20px;height:20px;color:#6D7786;">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-4.35-4.35M10 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16z"/>
                    </svg>
                </div>

                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari kelas..."
                    class="flex-1 min-w-0 h-full bg-transparent outline-none
                           text-[#111827] placeholder:text-[#6D7786]"
                />
            </div>
        </div>

        {{-- SEARCH BUTTON --}}
        <button type="submit"
                class="px-10 rounded-[30px] font-semibold transition-all duration-300"
                style="background:#1D4ED8;color:#fff;padding: 20px;">
            Search
        </button>

        {{-- RESET BUTTON --}}
        <a href="{{ route('my-courses.index') }}"
           class="px-10 rounded-[30px] font-semibold transition-all duration-300
                  flex items-center justify-center"
           style="background:#DC2626;color:#fff;padding: 20px;">
            Reset
        </a>
    </form>

    @php
        $activeTab = request('tab', 'all');
        $base = request()->except('page', 'tab');
        $tabs = [
            'all' => 'All Courses',
            'premium' => 'Premium',
            'starter' => 'Starter',
            'finished' => 'Finished',
        ];
    @endphp

    @if($courses->isEmpty())
        <div class="bg-white rounded-[24px] p-10 text-center ring-1 ring-[#DADEE4]">
            <p class="text-[#6D7786] mb-6">
                Belum ada course yang kamu beli/ikuti.
            </p>
            <a href="{{ route('home') }}"
               class="text-white font-semibold rounded-[30px] p-[16px_32px] bg-[#FF6129]
                      transition-all duration-300 hover:shadow-[0_10px_20px_0_#FF612980] inline-block">
                Explore Courses
            </a>
        </div>
    @else
        <div class="grid grid-cols-3 gap-[30px] w-full">
            @foreach($courses as $course)
                @php
                    $thumbPath = $course->thumbnail
                        ? 'storage/' . $course->thumbnail
                        : 'assets/thumbnail/thumbnail-1.png';
                    $thumbUrl  = \Illuminate\Support\Str::startsWith($thumbPath, ['http', 'https'])
                        ? $thumbPath
                        : asset($thumbPath);
                @endphp

                <div class="course-card">
                    <div class="flex flex-col rounded-t-[12px] rounded-b-[24px] gap-[32px] bg-white w-full pb-[10px]
                                overflow-hidden ring-1 ring-[#DADEE4] transition-all duration-300 hover:ring-2 hover:ring-[#FF6129]">

                        <a href="{{ route('courses.show', $course->slug) }}"
                           class="thumbnail w-full h-[200px] shrink-0 rounded-[10px] overflow-hidden">
                            <img src="{{ $thumbUrl }}" class="w-full h-full object-cover" alt="{{ $course->name }}">
                        </a>

                        <div class="flex flex-col px-4 gap-[32px]">
                            <div class="flex flex-col gap-[10px]">
                                <a href="{{ route('courses.show', $course->slug) }}"
                                   class="font-semibold text-lg line-clamp-2 hover:line-clamp-none min-h-[56px]">
                                    {{ $course->name }}
                                </a>

                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-[2px]">
                                        <div><img src="{{ asset('assets/icon/star.svg') }}" alt="star"></div>
                                        <div><img src="{{ asset('assets/icon/star.svg') }}" alt="star"></div>
                                        <div><img src="{{ asset('assets/icon/star.svg') }}" alt="star"></div>
                                        <div><img src="{{ asset('assets/icon/star.svg') }}" alt="star"></div>
                                        <div><img src="{{ asset('assets/icon/star.svg') }}" alt="star"></div>
                                    </div>
                                    <p class="text-right text-[#6D7786]">
                                        {{ $course->students_count ?? $course->students()->count() }} students
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                    <img src="{{ asset('assets/photo/photo1.png') }}" class="w-full h-full object-cover" alt="mentor">
                                </div>
                                <div class="flex flex-col">
                                    <p class="font-semibold">
                                        {{ $course->teacher?->user?->name ?? 'Mentor' }}
                                    </p>
                                    <p class="text-[#6D7786]">
                                        {{ $course->teacher?->job_title ?? 'Instructor' }}
                                    </p>
                                </div>
                            </div>

                            <a href="{{ route('my-courses.learn', $course->slug) }}"
                               class="text-white font-semibold rounded-[30px] p-[16px_32px] bg-[#FF6129]
                                      transition-all duration-300 hover:shadow-[0_10px_20px_0_#FF612980] text-center">
                                Continue Learning
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('user-menu-toggle');
        const menu   = document.getElementById('user-menu');

        if (toggle && menu) {
            toggle.addEventListener('click', function (e) {
                e.stopPropagation();
                menu.classList.toggle('hidden');
            });

            document.addEventListener('click', function () {
                if (!menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                }
            });

            menu.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        }
    });
</script>

{{-- MOBILE RESPONSIVE ONLY: desktop tidak berubah --}}
<style>
  @media (max-width: 640px) {

    body { padding-top: 16px !important; }

    #hero-section nav{
      padding-left: 16px !important;
      padding-right: 16px !important;
      flex-wrap: wrap;
      gap: 12px;
    }

    #hero-section nav img{
      height: 32px;
      width: auto;
    }

    #hero-section nav ul{
      gap: 14px !important;
      overflow-x: auto;
      white-space: nowrap;
      max-width: 100%;
      -webkit-overflow-scrolling: touch;
      scrollbar-width: none;
    }
    #hero-section nav ul::-webkit-scrollbar{ display:none; }

    section.max-w-\[1200px\]{
      padding-left: 16px !important;
      padding-right: 16px !important;
      padding-top: 28px !important;
      padding-bottom: 28px !important;
      gap: 18px !important;
    }

    section.max-w-\[1200px\] h2{
      font-size: 28px !important;
      line-height: 38px !important;
    }

    section.max-w-\[1200px\] p.text-lg{
      font-size: 14px !important;
      line-height: 22px !important;
    }

    form.w-full.flex.items-center.gap-4{
      flex-direction: column !important;
      align-items: stretch !important;
      gap: 12px !important;
    }

    form.w-full.flex.items-center.gap-4 button,
    form.w-full.flex.items-center.gap-4 a{
      width: 100% !important;
      height: 56px !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      padding: 0 18px !important;
      box-sizing: border-box !important;
    }

    .flex.items-center.gap-3{
      flex-wrap: wrap !important;
      gap: 10px !important;
    }

    .grid.grid-cols-3.gap-\[30px\].w-full{
      grid-template-columns: 1fr !important;
      gap: 16px !important;
    }

    .thumbnail.w-full.h-\[200px\]{
      height: 180px !important;
    }

    .course-card > div{ gap: 22px !important; }
    .course-card > div > div{ gap: 22px !important; }
  }
</style>

</body>
</html>
