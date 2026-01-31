{{-- resources/views/courses/index.blade.php --}}
@extends('layouts.front')

@section('title', 'Edutra.id – Saatnya Naik Level')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    {{-- HERO SECTION --}}
    <div id="hero-section"
     class="max-w-[1200px] mx-auto w-full flex flex-col gap-10 pb-[50px]
            bg-center bg-no-repeat bg-cover rounded-[32px] overflow-visible relative"
     style="background-image: url('{{ asset('assets/background/Hero-Banner.png') }}')">

    {{-- (opsional) overlay gelap supaya teks putih kebaca --}}
    <div class="absolute inset-0 bg-black/30 rounded-[32px] pointer-events-none"></div>

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

            <a href="{{ route('filament.student.auth.login') }}"
               class="text-white font-semibold rounded-[30px] p-[16px_32px] bg-[#FF6129]
                      transition-all duration-300 hover:shadow-[0_10px_20px_0_#FF612980] no-underline">
                Register
            </a>
        </div>
    @endauth
</nav>

        <div class="flex flex-col items-center gap-[30px]">
            <div class="w-fit flex items-center gap-3 p-2 pr-6 rounded-full bg-[#FFFFFF1F] border border-[#3477FF24]">
                <div class="w-[100px] h-[48px] flex shrink-0">
                    <img src="{{ asset('assets/icon/avatar-group.png') }}" class="object-contain" alt="icon">
                </div>
                <p class="font-semibold text-sm text-white">Join 3 million users</p>
            </div>
            <div class="flex flex-col gap-[10px]">
                <h1 class="font-semibold text-[80px] leading-[82px] text-center gradient-text-hero">
                    Saatnya Naik Level.
                </h1>
                <p class="text-center text-xl leading-[36px] text-[#F5F8FA]">
                    Setiap langkah kecil hari ini adalah bekal untuk karier yang   <br>
                   lebih besar esok hari bersama Edutra.
                </p>
            </div>
            <div class="flex gap-6 w-fit">
                <a href="#Popular-Courses"
                   class="text-white font-semibold rounded-[30px] p-[16px_32px] bg-[#FF6129]
                          transition-all duration-300 hover:shadow-[0_10px_20px_0_#FF612980]">
                    Explore Courses
                </a>
                <a href="#Pricing"
                   class="text-white font-semibold rounded-[30px] p-[16px_32px] ring-1 ring-white
                          transition-all duration-300 hover:ring-2 hover:ring-[#FF6129]">
                    Career Guidance
                </a>
            </div>
        </div>
        {{-- <div class="flex gap-[70px] items-center justify-center">
            <div>
                <img src="{{ asset('assets/icon/logo-55.svg') }}" alt="icon">
            </div>
            <div>
                <img src="{{ asset('assets/icon/logo.svg') }}" alt="icon">
            </div>
            <div>
                <img src="{{ asset('assets/icon/logo-54.svg') }}" alt="icon">
            </div>
            <div>
                <img src="{{ asset('assets/icon/logo.svg') }}" alt="icon">
            </div>
            <div>
                <img src="{{ asset('assets/icon/logo-52.svg') }}" alt="icon">
            </div>
        </div> --}}
    </div>

    {{-- TOP CATEGORIES (masih statis) --}}
    <section id="Top-Categories" class="max-w-[1200px] mx-auto flex flex-col p-[70px_50px] gap-[30px]">
        <div class="flex flex-col gap-[30px]">
            <div class="gradient-badge w-fit p-[8px_16px] rounded-full border border-[#FED6AD]
                        flex items-center gap-[6px]">
                <div>
                    <img src="{{ asset('assets/icon/medal-star.svg') }}" alt="icon">
                </div>
                <p class="font-medium text-sm text-[#FF6129]">Top Categories</p>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-[40px] leading-[60px]">Jelajahi Kelas</h2>
                <p class="text-[#6D7786] text-lg -tracking-[2%]">
                    Ikuti perkembangan skill on-demand dan raih peluang karier terbaik tahun ini.
                </p>
            </div>
        </div>
        
        <div class="grid grid-cols-3 gap-[30px]">
            <a href="#" class="card flex items-center p-4 gap-3 ring-1 ring-[#DADEE4] rounded-2xl
                               hover:ring-2 hover:ring-[#FF6129] transition-all duration-300">
                <div class="w-[70px] h-[70px] flex shrink-0">
                    <img src="{{ asset('assets/icon/Web Development 1-1.svg') }}" class="object-contain" alt="icon">
                </div>
                <p class="font-bold text-lg">Teknologi & Inovasi</p>
            </a>
            <a href="#" class="card flex items-center p-4 gap-3 ring-1 ring-[#DADEE4] rounded-2xl
                               hover:ring-2 hover:ring-[#FF6129] transition-all duration-300">
                <div class="w-[70px] h-[70px] flex shrink-0">
                    <img src="{{ asset('assets/icon/Web Development 1-4.svg') }}" class="object-contain" alt="icon">
                </div>
                <p class="font-bold text-lg">Bisnis & Karier</p>
            </a>
            <a href="#" class="card flex items-center p-4 gap-3 ring-1 ring-[#DADEE4] rounded-2xl
                               hover:ring-2 hover:ring-[#FF6129] transition-all duration-300">
                <div class="w-[70px] h-[70px] flex shrink-0">
                    <img src="{{ asset('assets/icon/Web Development 1.svg') }}" class="object-contain" alt="icon">
                </div>
                <p class="font-bold text-lg">Data & Analitik</p>
            </a>
        </div>
    </section>

    {{-- POPULAR COURSES – DI-BLADE-KAN DARI STATIC --}}
    <section id="Popular-Courses"
             class="max-w-[1200px] mx-auto flex flex-col p-[70px_82px_0px] gap-[30px]
                    bg-[#F5F8FA] rounded-[32px]">
        <div class="flex flex-col gap-[30px] items-center text-center">
            <div class="gradient-badge w-fit p-[8px_16px] rounded-full border border-[#FED6AD]
                        flex items-center gap-[6px]">
                <div>
                    <img src="{{ asset('assets/icon/medal-star.svg') }}" alt="icon">
                </div>
                <p class="font-medium text-sm text-[#FF6129]">Popular Courses</p>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-[40px] leading-[60px]">Yuk Upgrade Skill!</h2>
                <p class="text-[#6D7786] text-lg -tracking-[2%]">
                    Kuasai skill yang sedang dibutuhkan dan raih peluang karier bergaji tinggi tahun ini.
                </p>
            </div>
        </div>
        <div class="relative">
            <button class="btn-prev absolute rotate-180 -left-[52px] top-[216px]">
                <img src="{{ asset('assets/icon/arrow-right.svg') }}" alt="icon">
            </button>
            <button class="btn-prev absolute -right-[52px] top-[216px]">
                <img src="{{ asset('assets/icon/arrow-right.svg') }}" alt="icon">
            </button>

            <div id="course-slider" class="w-full">
                @forelse($courses as $course)
                    @php
                        // Kalau pakai Filament FileUpload disk('public'),
                        // biasanya $course->thumbnail = 'courses/thumbnails/namafile.png'

                        $thumbPath = $course->thumbnail
                            ? 'storage/' . $course->thumbnail   // <-- tambahkan "storage/"
                            : 'assets/thumbnail/thumbnail-1.png';

                        $thumbUrl  = Str::startsWith($thumbPath, ['http', 'https'])
                            ? $thumbPath
                            : asset($thumbPath);
                    @endphp

                    <div class="course-card w-1/3 px-3 pb-[70px] mt-[2px]">
                        <div class="flex flex-col rounded-t-[12px] rounded-b-[24px] gap-[32px]
                                    bg-white w-full pb-[10px] overflow-hidden
                                    transition-all duration-300 hover:ring-2 hover:ring-[#FF6129]">
                            <a href="{{ route('courses.show', $course->slug) }}"
                               class="thumbnail w-full h-[200px] shrink-0 rounded-[10px] overflow-hidden">
                                <img src="{{ $thumbUrl }}" class="w-full h-full object-cover"
                                     alt="{{ $course->name }}">
                            </a>
                            <div class="flex flex-col px-4 gap-[10px]">
                                <a href="{{ route('courses.show', $course->slug) }}"
                                   class="font-semibold text-lg line-clamp-2 hover:line-clamp-none min-h-[56px]">
                                    {{ $course->name }}
                                </a>
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-[2px]">
                                        @for($i = 0; $i < 5; $i++)
                                            <div>
                                                <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                            </div>
                                        @endfor
                                    </div>
                                    <p class="text-right text-[#6D7786]">
                                        {{ $course->students_count ?? 0 }} students
                                    </p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                        {{-- sementara pakai avatar statis --}}
                                        <img src="{{ asset('assets/photo/photo1.png') }}" class="w-full h-full object-cover" alt="icon">
                                    </div>
                                    <div class="flex flex-col">
                                        <p class="font-semibold">
                                            {{ $course->teacher?->user?->name ?? 'Mentor' }}
                                        </p>
                                        <p class="text-[#6D7786]">
                                            {{ $course->category->name ?? 'Category' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-10">
                        Belum ada course yang tersedia.
                    </p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- PRICING SECTION --}}
    <section id="Pricing"
             class="max-w-[1200px] mx-auto flex justify-between items-center p-[70px_100px]">
        <div class="relative">
            <div class="w-[355px] h-[488px]">
                <img src="{{ asset('assets/background/benefit_illustration.svg') }}" alt="icon">
            </div>
            <div class="absolute w-[230px] transform -translate-y-1/2 top-1/2 left-[214px] bg-white z-10
                        rounded-[20px] gap-4 p-4 flex flex-col shadow-[0_17px_30px_0_#0D051D0A]">
                <p class="font-semibold">Materials</p>
                <div class="flex gap-2 items-center">
                    <div>
                        <img src="{{ asset('assets/icon/video-play.svg') }}" alt="icon">
                    </div>
                    <p class="font-medium">Videos</p>
                </div>
                <div class="flex gap-2 items-center">
                    <div>
                        <img src="{{ asset('assets/icon/note-favorite.svg') }}" alt="icon">
                    </div>
                    <p class="font-medium">Handbook</p>
                </div>
                <div class="flex gap-2 items-center">
                    <div>
                        <img src="{{ asset('assets/icon/3dcube.svg') }}" alt="icon">
                    </div>
                    <p class="font-medium">Assets</p>
                </div>
                <div class="flex gap-2 items-center">
                    <div>
                        <img src="{{ asset('assets/icon/award.svg') }}" alt="icon">
                    </div>
                    <p class="font-medium">Certificates</p>
                </div>
                <div class="flex gap-2 items-center">
                    <div>
                        <img src="{{ asset('assets/icon/book.svg') }}" alt="icon">
                    </div>
                    <p class="font-medium">Documentations</p>
                </div>
            </div>
        </div>
        <div class="flex flex-col text-left gap-[30px]">
            <h2 class="font-bold text-[36px] leading-[52px]">
                Learn From Anywhere,<br>Anytime You Want
            </h2>
            <p class="text-[#475466] text-lg leading-[34px]">
                Tingkatkan skill tanpa batas <br>
                dengan akses penuh ke seluruh materi pembelajaran.
            </p>
            <a href="#"
               class="text-white font-semibold rounded-[30px] p-[16px_32px] bg-[#FF6129]
                      transition-all duration-300 hover:shadow-[0_10px_20px_0_#FF612980] w-fit">
                Check Pricing
            </a>
        </div>
    </section>


    
    
    <section id="FAQ" class="max-w-[1200px] mx-auto flex flex-col py-[70px] px-[100px]">
        <div class="flex justify-between items-center">
            <div class="flex flex-col gap-[30px]">
                <div class="gradient-badge w-fit p-[8px_16px] rounded-full border border-[#FED6AD] flex items-center gap-[6px]">
                    <div>
                        <img src="assets/icon/medal-star.svg" alt="icon">
                    </div>
                    <p class="font-medium text-sm text-[#FF6129]">Grow Your Career</p>
                </div>
                <div class="flex flex-col">
                    <h2 class="font-bold text-[36px] leading-[52px]">Dapatkan Jawabanmu</h2>
                    <p class="text-lg text-[#475466]">Saatnya meningkatkan keterampilan tanpa batas!</p>
                </div>
                <a href="" class="text-white font-semibold rounded-[30px] p-[16px_32px] bg-[#FF6129] transition-all duration-300 hover:shadow-[0_10px_20px_0_#FF612980] w-fit">Contact Our Sales</a>
            </div>
            <div class="flex flex-col gap-[30px] w-[552px] shrink-0">
                <div class="flex flex-col p-5 rounded-2xl bg-[#FFF8F4] has-[.hide]:bg-transparent border-t-4 border-[#FF6129] has-[.hide]:border-0 w-full">
                    <button class="accordion-button flex justify-between gap-1 items-center" data-accordion="accordion-faq-1">
                        <span class="font-semibold text-lg text-left">Apakah pemula bisa mengikuti kelas di edutra.id?</span>
                        <div class="arrow w-9 h-9 flex shrink-0">
                            <img src="assets/icon/add.svg" alt="icon">
                        </div>
                    </button>
                    <div id="accordion-faq-1" class="accordion-content hide">
                        <p class="leading-[30px] text-[#475466] pt-[10px]">Ya, tentu bisa.
edutra.id menyediakan kelas dari tingkat pemula hingga lanjutan. Materi disusun secara bertahap sehingga mudah dipahami, bahkan tanpa pengalaman sebelumnya.</p>
                    </div>
                </div>
                <div class="flex flex-col p-5 rounded-2xl bg-[#FFF8F4] has-[.hide]:bg-transparent border-t-4 border-[#FF6129] has-[.hide]:border-0 w-full">
                    <button class="accordion-button flex justify-between gap-1 items-center" data-accordion="accordion-faq-2">
                        <span class="font-semibold text-lg text-left">Bagaimana sistem belajar di edutra.id?</span>
                        <div class="arrow w-9 h-9 flex shrink-0">
                            <img src="assets/icon/add.svg" alt="icon">
                        </div>
                    </button>
                    <div id="accordion-faq-2" class="accordion-content hide">
                        <p class="leading-[30px] text-[#475466] pt-[10px]">Belajar 100% online dan fleksibel.
Kamu bisa mengakses materi kapan saja dan di mana saja melalui web. Tersedia video pembelajaran, modul, kuis, dan studi kasus praktis.</p>
                    </div>
                </div>
                <div class="flex flex-col p-5 rounded-2xl bg-[#FFF8F4] has-[.hide]:bg-transparent border-t-4 border-[#FF6129] has-[.hide]:border-0 w-full">
                    <button class="accordion-button flex justify-between gap-1 items-center" data-accordion="accordion-faq-3">
                        <span class="font-semibold text-lg text-left">Berapa lama durasi setiap kelas?</span>
                        <div class="arrow w-9 h-9 flex shrink-0">
                            <img src="assets/icon/add.svg" alt="icon">
                        </div>
                    </button>
                    <div id="accordion-faq-3" class="accordion-content hide">
                        <p class="leading-[30px] text-[#475466] pt-[10px]">Durasi kelas bervariasi tergantung topik.
Rata-rata kelas dapat diselesaikan dalam beberapa minggu, dan kamu bisa belajar sesuai ritme sendiri tanpa batasan waktu ketat.</p>
                    </div>
                </div>
                <div class="flex flex-col p-5 rounded-2xl bg-[#FFF8F4] has-[.hide]:bg-transparent border-t-4 border-[#FF6129] has-[.hide]:border-0 w-full">
                    <button class="accordion-button flex justify-between gap-1 items-center" data-accordion="accordion-faq-4">
                        <span class="font-semibold text-lg text-left">Apakah saya akan mendapatkan sertifikat?</span>
                        <div class="arrow w-9 h-9 flex shrink-0">
                            <img src="assets/icon/add.svg" alt="icon">
                        </div>
                    </button>
                    <div id="accordion-faq-4" class="accordion-content hide">
                        <p class="leading-[30px] text-[#475466] pt-[10px]">Ya.
Setelah menyelesaikan kelas dan memenuhi syarat kelulusan, kamu akan mendapatkan sertifikat digital yang dapat digunakan untuk portofolio atau kebutuhan profesional.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER (khusus halaman ini, jadi tidak wajib tampil di halaman lain) --}}
    <footer class="max-w-[1200px] mx-auto flex flex-col pt-[70px] pb-[50px] px-[100px]
                    gap-[50px] bg-[#F5F8FA] rounded-[32px]">
        <div class="flex justify-between">
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
                    <li><a href="#" class="text-[#6D7786]">Terms &amp; Conditions</a></li>
                </ul>
            </div>
        </div>
        <div class="w-full h-[51px] flex items-end border-t border-[#E7EEF2]">
            <p class="mx-auto text-sm text-[#6D7786] -tracking-[2%]">
                All Rights Reserved edutra.id {{ date('Y') }}
            </p>
        </div>
    </footer>
@endsection
<script>
document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.getElementById('user-menu-toggle');
  const menu = document.getElementById('user-menu');

  if (!toggle || !menu) return;

  toggle.addEventListener('click', (e) => {
    e.stopPropagation();
    menu.classList.toggle('hidden');
  });

  document.addEventListener('click', () => {
    menu.classList.add('hidden');
  });

  menu.addEventListener('click', (e) => e.stopPropagation());
});
</script>
