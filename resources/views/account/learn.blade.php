<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('output.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
</head>

<body class="font-poppins bg-[#F5F8FA] text-black">

    {{-- HERO SECTION (FIXED: background aman + overlay supaya warna menu masuk) --}}
<div id="hero-section"
     style="background-image: url('{{ asset('assets/background/Hero-Banner.png') }}');"
     class="relative max-w-[1200px] mx-auto w-full flex flex-col gap-10
            bg-center bg-no-repeat bg-cover rounded-[32px] overflow-hidden">

    {{-- overlay agar menu putih selalu terlihat --}}
    <div class="absolute inset-0 bg-black/30"></div>

    {{-- NAVBAR (menu tetap) --}}
    <nav class="relative z-10 flex justify-between items-center py-6 px-[50px]">
        <a href="{{ route('home') }}">
            <img src="{{ asset('assets/logo/logo.svg') }}" alt="logo">
        </a>

        <ul class="flex items-center gap-[30px] text-white">
            <li><a href="{{ route('home') }}" class="font-semibold hover:text-[#FF6129] transition">Home</a></li>
            <li><a href="#" class="font-semibold hover:text-[#FF6129] transition">Pricing</a></li>
            <li><a href="#" class="font-semibold hover:text-[#FF6129] transition">Benefits</a></li>
            <li><a href="#" class="font-semibold hover:text-[#FF6129] transition">Stories</a></li>
        </ul>

        {{-- AUTH AREA: kalau login tampil dropdown, kalau tidak tampil tombol SignUp/SignIn (sesuai template) --}}
        @auth
            <div class="relative flex gap-[10px] items-center">
                <div class="flex flex-col items-end justify-center">
                    <p class="font-semibold text-white">
                        Halo, {{ auth()->user()->name }}
                    </p>
                    <p class="p-[2px_10px] rounded-full bg-[#FF6129] font-semibold text-xs text-white text-center">
                        PRO
                    </p>
                </div>

                <button
                    type="button"
                    id="user-menu-toggle"
                    class="w-[56px] h-[56px] overflow-hidden rounded-full flex shrink-0 border border-white/40"
                >
                    <img src="{{ asset('assets/photo/photo5.png') }}"
                         class="w-full h-full object-cover"
                         alt="photo">
                </button>

                <div
                    id="user-menu"
                    class="hidden absolute right-0 top-[72px] flex-col w-48
                           bg-white rounded-2xl shadow-lg py-2 z-50 overflow-hidden"
                >
                    <a href="{{ route('my-courses.index') }}"
                       class="px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                        My Courses
                    </a>
                    <a href="{{ route('settings.edit') }}"
                       class="px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                        Settings
                    </a>

                    <form method="POST" action="{{ url('/logout') }}"
                          class="mt-1 pt-1 border-t border-gray-100">
                        @csrf
                        <button type="submit"
                                class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="flex gap-[10px] items-center">
                <a href="#" class="text-white font-semibold rounded-[30px] p-[16px_32px] ring-1 ring-white transition-all duration-300 hover:ring-2 hover:ring-[#FF6129]">
                    Sign Up
                </a>
                <a href="#" class="text-white font-semibold rounded-[30px] p-[16px_32px] bg-[#FF6129] transition-all duration-300 hover:shadow-[0_10px_20px_0_#FF612980]">
                    Sign In
                </a>
            </div>
        @endauth
    </nav>

    {{-- HERO TITLE --}}
</div>

{{-- HEADER / NAVBAR --}}
<div class="max-w-[1200px] mx-auto px-6 py-6">
    <a href="{{ route('my-courses.index') }}"
       class="text-[#FF6129] font-semibold">
        ← Back to My Courses
    </a>
</div>

@php
    /**
     * Convert YouTube URL → embed URL
     * support:
     * - youtube.com/watch?v=xxx&t=3s
     * - youtu.be/xxx
     */
    function youtubeEmbed($url){
        if(!$url) return null;

        $start = 0;
        parse_str(parse_url($url, PHP_URL_QUERY) ?? '', $q);

        if(isset($q['t'])){
            if(is_numeric($q['t'])){
                $start = (int)$q['t'];
            } else {
                preg_match_all('/(\d+)(h|m|s)/', $q['t'], $m, PREG_SET_ORDER);
                foreach($m as $p){
                    if($p[2]=='h') $start += $p[1]*3600;
                    if($p[2]=='m') $start += $p[1]*60;
                    if($p[2]=='s') $start += $p[1];
                }
            }
        }

        if(isset($q['v'])){
            return 'https://www.youtube.com/embed/'.$q['v'].($start ? '?start='.$start : '');
        }

        if(preg_match('~youtu\.be/([^?&]+)~', $url, $m)){
            return 'https://www.youtube.com/embed/'.$m[1].($start ? '?start='.$start : '');
        }

        return $url;
    }

    $embedUrl = $activeVideo ? youtubeEmbed($activeVideo->path_video) : null;
@endphp

{{-- MAIN CONTENT --}}
<section class="max-w-[1200px] mx-auto px-6 pb-12">

    <div class="learn-layout">

        {{-- PLAYLIST (LEFT) --}}
        <aside class="bg-white rounded-[24px] ring-1 ring-[#DADEE4] p-5">
            <h3 class="font-bold text-lg mb-4">
                {{ $course->name }}
            </h3>
        </br>
            <div class="flex flex-col gap-3">
                @foreach($videos as $video)
                    <a href="{{ route('my-courses.learn', [$course->slug, 'video'=>$video->id]) }}"
                       class="p-4 rounded-[18px] ring-1 transition-all duration-300 
                       {{ $activeVideo && $activeVideo->id === $video->id
                            ? 'bg-[#111827] ring-[#111827]' 
                            : 'bg-[#F5F8FA] ring-[#E7EEF2] hover:ring-[#FF6129]' }}" >
                        <p class="font-semibold text-sm">
                            {{ $video->name }}
                        </p>
                    </a>
                @endforeach
            </div>
        </aside>

        {{-- VIDEO PLAYER (RIGHT) --}}
        <main class="bg-white rounded-[24px] ring-1 ring-[#DADEE4] overflow-hidden">
            <div class="p-5 border-b border-[#E7EEF2]">
                <h2 class="font-bold text-xl">
                    {{ $activeVideo?->name }}
                </h2>
                <p class="text-sm text-[#6D7786]">
                    {{ $course->name }}
                </p>
            </div>

            <div class="p-5">
                @if($embedUrl)
                  <div class="w-full bg-black rounded-[18px] overflow-hidden shadow-lg">
                    <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
                        <iframe
                            src="{{ $embedUrl }}"
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
                @else
                    <div class="aspect-video flex items-center justify-center text-[#6D7786]">
                        Video tidak tersedia
                    </div>
                @endif
            </div>
        </main>

    </div>
</section>

{{-- RESPONSIVE LAYOUT --}}
<style>
.learn-layout{
    display:grid;
    grid-template-columns: 1fr;
    gap:24px;
}

@media(min-width:1024px){
    .learn-layout{
        grid-template-columns: 360px 1fr;
        align-items:start;
    }
}
</style>

</body>
</html>
