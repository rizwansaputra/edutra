<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Checkout - {{ $course->name }}</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
body{
    font-family:'Poppins',sans-serif;
    background:#eef2f5;
}

.hero{
    background:url('{{ asset("assets/background/Hero-Banner.png") }}') center/cover no-repeat;
    border-radius:32px;
    padding:40px 50px 80px 50px;
    margin-top:40px;
    position:relative;
}

.hero h2{
    font-weight:700;
}

.card-box{
    border-radius:24px;
    padding:30px;
}

.badge-orange{
    background:#FF6129;
}

.btn-orange{
    background:#FF6129;
    color:white;
    border:none;
}

.btn-orange:hover{
    background:#e3541f;
    color:white;
}

.footer-bg{
    background:#F5F8FA;
    border-radius:32px;
    padding:50px;
    margin-top:60px;
}
</style>
</head>

<body>

{{-- HERO SECTION --}}
<div class="container hero text-white">

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-dark">

        <div class="container-fluid">

            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('assets/logo/logo.svg') }}" height="40">
            </a>

            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarCheckout">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-center"
                 id="navbarCheckout">

                <ul class="navbar-nav mx-auto text-center">
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="#">Kelas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="https://edutra.id/product-digital/">Produk Digital</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="#">Stories</a>
                    </li>
                </ul>

                {{-- AUTH --}}
                @auth
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle rounded-pill px-4"
                                data-bs-toggle="dropdown">
                            Hi, {{ auth()->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('my-courses.index') }}">
                                    My Courses
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('settings.edit') }}">
                                    Settings
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST"
                                      action="{{ route('filament.student.auth.logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="d-flex gap-2 mt-3 mt-lg-0">
                        <a href="{{ route('filament.student.auth.login') }}"
                           class="btn btn-outline-light rounded-pill px-4">
                            Login
                        </a>
                        <a href="{{ url('/register') }}"
                           class="btn btn-orange rounded-pill px-4">
                            Register
                        </a>
                    </div>
                @endauth

            </div>
        </div>
    </nav>

    {{-- TITLE --}}
    <div class="text-center mt-4">
        <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
            Invest In Yourself Today
        </span>

        <h2 class="mt-3">
            Checkout Subscription (Free)
        </h2>
    </div>

</div>


{{-- CONTENT --}}
<div class="container mt-5">

    <div class="row g-4">

        {{-- LEFT --}}
        <div class="col-md-6">
            <div class="bg-white shadow-sm card-box h-100">

                <h5 class="fw-bold mb-4">Package</h5>

                <div class="d-flex justify-content-between align-items-center">

                    <div class="d-flex align-items-center gap-3">
                        <img src="{{ asset('assets/icon/Web Development 1.svg') }}"
                             width="50" height="50">

                        <div>
                            <div class="fw-semibold">
                                {{ $course->name }}
                            </div>
                            <small class="text-muted">Free access</small>
                        </div>
                    </div>

                    <span class="badge badge-orange text-white rounded-pill px-3 py-2">
                        Free
                    </span>
                </div>

                <hr>

                <ul class="list-unstyled small">
                    <li class="mb-2">✔ Access course videos</li>
                    <li>✔ Join learning community</li>
                </ul>

                <h4 class="fw-bold mt-3">Rp 0</h4>

            </div>
        </div>


        {{-- RIGHT --}}
        <div class="col-md-6">
            <div class="bg-white shadow-sm card-box h-100">

                <h5 class="fw-bold mb-4">Confirm Free Access</h5>

                <div class="small mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Course</span>
                        <span class="fw-semibold">{{ $course->name }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Category</span>
                        <span class="fw-semibold">
                            {{ $course->category->name ?? 'Uncategorized' }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">User</span>
                        <span class="fw-semibold">
                            {{ auth()->check() ? auth()->user()->name : 'Guest' }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Price</span>
                        <span class="fw-semibold">Rp 0</span>
                    </div>
                </div>

                <hr>

                @auth
                    <form action="{{ route('checkout.activate', $course) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="btn btn-orange w-100 rounded-pill py-3 fw-semibold">
                            Activate Free Access
                        </button>
                    </form>
                @else
                    <p class="small text-muted">
                        Silakan login terlebih dahulu untuk mengaktifkan course.
                    </p>

                    <a href="{{ route('checkout.login', $course) }}"
                       class="btn btn-orange w-100 rounded-pill py-3 fw-semibold">
                        Login untuk melanjutkan
                    </a>
                @endauth

            </div>
        </div>

    </div>

</div>


{{-- FOOTER --}}
<div class="container footer-bg">

    <div class="row">
        <div class="col-lg-3 mb-3">
            <img src="{{ asset('assets/logo/logo-black.svg') }}" height="40">
        </div>

        <div class="col-lg-3 mb-3">
            <h6 class="fw-bold">Products</h6>
            <p class="text-muted small mb-1">Online Courses</p>
            <p class="text-muted small">Career Guidance</p>
        </div>

        <div class="col-lg-3 mb-3">
            <h6 class="fw-bold">Company</h6>
            <p class="text-muted small mb-1">About Us</p>
            <p class="text-muted small">Careers</p>
        </div>

        <div class="col-lg-3 mb-3">
            <h6 class="fw-bold">Resources</h6>
            <p class="text-muted small mb-1">Blog</p>
            <p class="text-muted small">Help Center</p>
        </div>
    </div>

    <hr>

    <p class="text-center text-muted small mb-0">
        © 2024 Edutra. All Rights Reserved.
    </p>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
