@extends('layouts.front')

@section('title', 'Edutra.id – Saatnya Naik Level')

@section('content')

<!-- ================= HERO ================= -->
<section class="hero-section container mt-5">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('assets/logo/logo.svg') }}" height="40">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#Popular-Courses">Kelas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Produk Digital</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Stories</a>
                    </li>
                </ul>

                <div>
                    @auth
                        <a href="{{ url('/student/my-courses') }}" 
                           class="btn btn-outline-light rounded-pill me-2">
                            My Courses
                        </a>

                        <form action="{{ route('filament.student.auth.logout') }}" 
                              method="POST" 
                              class="d-inline">
                            @csrf
                            <button class="btn btn-primary-custom rounded-pill">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('filament.student.auth.login') }}" 
                           class="btn btn-outline-light rounded-pill me-2">
                            Login
                        </a>
                        <a href="{{ url('/register') }}" 
                           class="btn btn-primary-custom rounded-pill">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO CONTENT -->
    <div class="text-center text-white py-5">
        <p class="badge-custom mb-4">
            <img src="{{ asset('assets/icon/avatar-group.png') }}" height="30">
            Join 3 million users
        </p>

        <h1 class="display-4 fw-bold">Saatnya Naik Level.</h1>
        <p class="lead mt-3">
            Setiap langkah kecil hari ini adalah bekal untuk karier yang
            lebih besar esok hari bersama Edutra.
        </p>

        <div class="mt-4">
            <a href="#Popular-Courses" 
               class="btn btn-primary-custom rounded-pill me-3">
                Explore Courses
            </a>
            <a href="#Pricing" 
               class="btn btn-outline-light rounded-pill">
                Career Guidance
            </a>
        </div>
    </div>

</section>


<!-- ================= CATEGORIES ================= -->
<section class="container section-padding">
    <div class="text-center mb-5">
        <span class="badge-title">Top Categories</span>
        <h2 class="fw-bold mt-3">Jelajahi Kelas</h2>
        <p class="text-muted">
            Ikuti perkembangan skill on-demand dan raih peluang karier terbaik tahun ini.
        </p>
    </div>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="category-card text-center">
                <img src="{{ asset('assets/icon/Web Development 1-1.svg') }}" height="60">
                <h6 class="fw-bold mt-3">Teknologi & Inovasi</h6>
            </div>
        </div>

        <div class="col-md-4">
            <div class="category-card text-center">
                <img src="{{ asset('assets/icon/Web Development 1-4.svg') }}" height="60">
                <h6 class="fw-bold mt-3">Bisnis & Karier</h6>
            </div>
        </div>

        <div class="col-md-4">
            <div class="category-card text-center">
                <img src="{{ asset('assets/icon/Web Development 1.svg') }}" height="60">
                <h6 class="fw-bold mt-3">Data & Analitik</h6>
            </div>
        </div>

    </div>
</section>


<!-- ================= POPULAR COURSES ================= -->
<section id="Popular-Courses" class="container popular-section my-5">
    <div class="section-box p-5 rounded-4">

        <div class="text-center mb-5">
            <span class="badge-title">Popular Courses</span>
            <h2 class="fw-bold mt-3">Yuk Upgrade Skill!</h2>
            <p class="text-muted">
                Kuasai skill yang sedang dibutuhkan dan raih peluang karier terbaik.
            </p>
        </div>

        <div class="row g-4">

            @forelse($courses as $course)

                @php
                    $thumb = $course->thumbnail 
                        ? asset('storage/' . $course->thumbnail) 
                        : asset('assets/thumbnail/thumbnail-1.png');
                @endphp

                <div class="col-lg-4 col-md-6">
                    <div class="card course-card h-100">

                        <a href="{{ route('courses.show', $course->slug) }}">
                            <img src="{{ $thumb }}" 
                                 class="card-img-top" 
                                 alt="{{ $course->name }}">
                        </a>

                        <div class="card-body">
                            <h6 class="fw-bold">
                                <a href="{{ route('courses.show', $course->slug) }}" 
                                   class="text-dark text-decoration-none">
                                    {{ $course->name }}
                                </a>
                            </h6>

                            <div class="d-flex justify-content-between mt-3">
                                <small class="text-warning">★★★★★</small>
                                <small class="text-muted">
                                    {{ $course->students_count ?? 0 }} students
                                </small>
                            </div>

                            <div class="d-flex align-items-center mt-3">
                                <img src="{{ asset('assets/photo/photo1.png') }}" 
                                     class="rounded-circle me-2" width="35">
                                <div>
                                    <small class="fw-semibold d-block">
                                        {{ $course->teacher?->user?->name ?? 'Mentor' }}
                                    </small>
                                    <small class="text-muted">
                                        {{ $course->category->name ?? 'Category' }}
                                    </small>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada course tersedia.</p>
                </div>
            @endforelse

        </div>
    </div>
</section>


<!-- ================= PRICING ================= -->
<section id="Pricing" class="container my-5 py-5">
    <div class="row align-items-center">

        <!-- LEFT IMAGE -->
        <div class="col-lg-5 mb-4 mb-lg-0 position-relative text-center">

            <img src="{{ asset('assets/background/benefit_illustration.png') }}"
                 class="img-fluid" style="max-height:480px;border-radius: 20px;" alt="illustration">

            <!-- Floating Card -->
            <div class="card shadow position-absolute top-50 translate-middle"
                 style="width:230px; border-radius:20px; left:70%; transform: translate(-50%, -50%);">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Materials</h6>

                    <div class="d-flex align-items-center mb-2">
                        <img src="{{ asset('assets/icon/video-play.svg') }}" width="20" class="me-2">
                        <small>Videos</small>
                    </div>

                    <div class="d-flex align-items-center mb-2">
                        <img src="{{ asset('assets/icon/note-favorite.svg') }}" width="20" class="me-2">
                        <small>Handbook</small>
                    </div>

                    <div class="d-flex align-items-center mb-2">
                        <img src="{{ asset('assets/icon/3dcube.svg') }}" width="20" class="me-2">
                        <small>Assets</small>
                    </div>

                    <div class="d-flex align-items-center mb-2">
                        <img src="{{ asset('assets/icon/award.svg') }}" width="20" class="me-2">
                        <small>Certificates</small>
                    </div>

                    <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/icon/book.svg') }}" width="20" class="me-2">
                        <small>Documentations</small>
                    </div>
                </div>
            </div>

        </div>

        <!-- RIGHT CONTENT -->
        <div class="col-lg-7">
            <h2 class="fw-bold mb-4">
                Learn From Anywhere,<br>Anytime You Want
            </h2>

            <p class="text-muted mb-4">
               Tingkatkan skill tanpa batas dengan akses penuh ke seluruh materi pembelajaran yang terstruktur, relevan, dan selalu diperbarui. Belajar fleksibel kapan saja, di mana saja, dan kuasai kompetensi yang dibutuhkan untuk naik level dalam karier maupun bisnis Anda.
            </p>

            <a href="#" class="btn btn-primary-custom rounded-pill px-4 py-2">
                Belajar Gratis
            </a>
        </div>

    </div>
</section>


<!-- ================= FAQ ================= -->
<section id="FAQ" class="container my-5 py-5">
    <div class="row align-items-start">
        <div class="col-lg-1 mb-4">
        </div>
        <!-- LEFT SIDE -->
        <div class="col-lg-4 mb-4">
            <span class="badge bg-light text-warning mb-3">
                <img src="{{ asset('assets/icon/medal-star.svg') }}" width="18" class="me-1">
                Grow Your Career
            </span>

            <h2 class="fw-bold mb-3">Dapatkan Jawabanmu</h2>

            <p class="text-muted mb-4">
                Saatnya meningkatkan keterampilan tanpa batas!
            </p>

            <a href="#" class="btn btn-primary-custom rounded-pill px-4 py-2">
                Hub Kami
            </a>
        </div>

        <!-- RIGHT SIDE -->
        <div class="col-lg-7">

            <div class="accordion" id="faqAccordion">

                <div class="accordion-item mb-3 rounded-3 border-0 shadow-sm">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-semibold"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#faq1">
                            Apakah pemula bisa mengikuti kelas di edutra.id?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse"
                         data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Ya, tentu bisa.
edutra.id menyediakan kelas dari tingkat pemula hingga lanjutan. Materi disusun secara bertahap sehingga mudah dipahami, bahkan tanpa pengalaman sebelumnya.
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3 rounded-3 border-0 shadow-sm">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-semibold"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#faq2">
                           Bagaimana sistem belajar di edutra.id?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse"
                         data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Belajar 100% online dan fleksibel.
Kamu bisa mengakses materi kapan saja dan di mana saja melalui web. Tersedia video pembelajaran, modul, kuis, dan studi kasus praktis.
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3 rounded-3 border-0 shadow-sm">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-semibold"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#faq3">
                            Berapa lama durasi setiap kelas?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse"
                         data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Durasi kelas bervariasi tergantung topik.
Rata-rata kelas dapat diselesaikan dalam beberapa minggu, dan kamu bisa belajar sesuai ritme sendiri tanpa batasan waktu ketat.
                        </div>
                    </div>
                </div>

                <div class="accordion-item rounded-3 border-0 shadow-sm">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-semibold"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#faq4">
                           Apakah saya akan mendapatkan sertifikat?
                        </button>
                    </h2>
                    <div id="faq4" class="accordion-collapse collapse"
                         data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Ya.
Setelah menyelesaikan kelas dan memenuhi syarat kelulusan, kamu akan mendapatkan sertifikat digital yang dapat digunakan untuk portofolio atau kebutuhan profesional.
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>


<!-- ================= FOOTER ================= -->
<footer class="container footer-section my-5">
    <div class="footer-box p-5 rounded-4">

        <div class="row gy-4">

            <div class="col-lg-3">
                <img src="{{ asset('assets/logo/logo-black.svg') }}" height="40">
            </div>

            <div class="col-lg-3 col-md-4">
                <h6 class="fw-bold mb-3">Products</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="#">Online Courses</a></li>
                    <li><a href="#">Career Guidance</a></li>
                    <li><a href="#">Expert Handbook</a></li>
                    <li><a href="#">Interview Simulations</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-4">
                <h6 class="fw-bold mb-3">Company</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Media Press</a></li>
                    <li>
                        <a href="#">
                            Careers <span class="hire-badge">We’re Hiring</span>
                        </a>
                    </li>
                    <li><a href="#">Developer APIs</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-4">
                <h6 class="fw-bold mb-3">Resources</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                </ul>
            </div>

        </div>

        <hr class="my-4">

        <div class="text-center text-muted small">
            All Rights Reserved edutra.id {{ date('Y') }}
        </div>

    </div>
</footer>

@endsection
