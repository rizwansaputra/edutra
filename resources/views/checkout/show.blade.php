{{-- resources/views/checkout/show.blade.php --}}
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Tailwind/output CSS --}}
    <link href="{{ asset('output.css') }}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
</head>

<body class="text-black font-poppins pt-10">

<div id="checkout-section"
     class="max-w-[1200px] mx-auto w-full min-h-[calc(100vh-40px)] d-flex flex-column gap-[30px]
            bg-center bg-no-repeat bg-cover rounded-t-[32px] overflow-hidden position-relative pb-6"
     style="background-image: url('{{ asset('assets/background/Hero-Banner.png') }}');">

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
                    <p class="font-semibold text-white mb-1">Hi, {{ auth()->user()->name }}</p>
                    <p class="p-[2px_10px] rounded-full bg-[#FF6129] font-semibold text-xs text-white text-center mb-0">
                        PRO
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
                    class="hidden absolute right-0 top-full mt-3 z-[9999] flex flex-col w-44
                           bg-white rounded-xl shadow-lg py-2 overflow-hidden"
                    style="min-width: 160px;"
                >
                    <a href="{{ route('my-courses.index') }}"
                       class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 no-underline">
                        My Courses
                    </a>

                    <a href="{{ route('settings.edit') }}"
                       class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 no-underline">
                        Settings
                    </a>

                    <form method="POST" action="{{ route('filament.student.auth.logout') }}"
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

    {{-- TITLE --}}
    <div class="d-flex flex-column gap-2 align-items-center mt-3">
        <div class="gradient-badge w-auto px-3 py-2 rounded-pill border border-[#FED6AD]
                    d-flex align-items-center gap-2 bg-white bg-opacity-80">
            <div>
                <img src="{{ asset('assets/icon/medal-star.svg') }}" alt="icon">
            </div>
            <p class="fw-medium small mb-0" style="color:#FF6129;">Invest In Yourself Today</p>
        </div>

        <h2 class="fw-bold text-white text-center" style="font-size:32px;line-height:48px;">
            Checkout Subscription (Free)
        </h2>
    </div>

    {{-- CONTENT --}}
    <div class="container position-relative mt-4" style="z-index:10;">
        <div class="row g-4 px-2 px-md-4">

            {{-- LEFT: PACKAGE --}}
            <div class="col-md-6">
                <div class="w-100 d-flex flex-column bg-white rounded-4 p-4 gap-3 h-100">
                    <p class="fw-bold fs-5 mb-2">Package</p>

                    <div class="d-flex align-items-center justify-content-between w-100">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle overflow-hidden flex-shrink-0" style="width:50px;height:50px;">
                                <img src="{{ asset('assets/icon/Web Development 1.svg') }}"
                                     class="w-100 h-100 object-cover" alt="photo">
                            </div>

                            <div class="d-flex flex-column gap-1">
                                <p class="fw-semibold mb-0">{{ $course->name }}</p>
                                <p class="small mb-0" style="color:#6D7786;">Free access</p>
                            </div>
                        </div>

                        <p class="mb-0 px-3 py-1 rounded-pill text-white text-center fw-semibold"
                           style="background-color:#FF6129;font-size:12px;">
                            Free
                        </p>
                    </div>

                    <hr>

                    <div class="d-flex flex-column gap-3 small">
                        <div class="d-flex gap-3">
                            <div style="width:24px;height:24px;" class="flex-shrink-0">
                                <img src="{{ asset('assets/icon/tick-circle.svg') }}"
                                     class="w-100 h-100 object-cover" alt="icon">
                            </div>
                            <p class="mb-0" style="color:#475466;">Access course videos</p>
                        </div>

                        <div class="d-flex gap-3">
                            <div style="width:24px;height:24px;" class="flex-shrink-0">
                                <img src="{{ asset('assets/icon/tick-circle.svg') }}"
                                     class="w-100 h-100 object-cover" alt="icon">
                            </div>
                            <p class="mb-0" style="color:#475466;">Join learning community</p>
                        </div>
                    </div>

                    <p class="fw-semibold mb-0 mt-2" style="font-size:24px;line-height:36px;">Rp 0</p>
                </div>
            </div>

            {{-- RIGHT: KONFIRMASI --}}
            <div class="col-md-6">
                <div class="w-100 d-flex flex-column bg-white rounded-4 p-4 gap-3 h-100">
                    <p class="fw-bold fs-5 mb-2">Confirm Free Access</p>

                    <div class="d-flex flex-column gap-3 small">
                        <div class="d-flex align-items-center justify-content-between">
                            <span style="color:#475466;">Course</span>
                            <span class="fw-semibold text-end">{{ $course->name }}</span>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <span style="color:#475466;">Category</span>
                            <span class="fw-semibold text-end">
                                {{ $course->category->name ?? 'Uncategorized' }}
                            </span>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <span style="color:#475466;">User</span>
                            <span class="fw-semibold text-end">
                                {{ auth()->check() ? auth()->user()->name : 'Guest' }}
                            </span>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <span style="color:#475466;">Price</span>
                            <span class="fw-semibold text-end">Rp 0</span>
                        </div>
                    </div>

                    <hr>

                    @if(auth()->check())
                        <form action="{{ route('checkout.activate', $course) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="p-[16px_32px] bg-[#FF6129] text-white rounded-full text-center font-semibold
                                           transition-all duration-300 hover:shadow-[0_10px_20px_0_#FF612980] w-full">
                                Activate Free Access
                            </button>
                        </form>
                    @else
                        <p class="small mb-2" style="color:#475466;">
                            Untuk mengaktifkan course ini, silakan login terlebih dahulu.
                        </p>

                        <a href="{{ route('checkout.login', $course) }}"
                           class="w-100 d-inline-block text-center py-3 rounded-pill fw-semibold text-white text-decoration-none"
                           style="background-color:#FF6129;transition:all .3s;">
                            Login untuk melanjutkan
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- BACKGROUND BAWAH: jangan sampai nangkep klik --}}
    <div class="d-flex justify-content-center position-absolute translate-middle-x start-50 bottom-0 w-100 opacity-75"
         style="pointer-events:none;">
        <img src="{{ asset('assets/background/alqowy.svg') }}" alt="background">
    </div>
</div>

{{-- JS --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="{{ asset('main.js') }}"></script>

{{-- Dropdown toggle --}}
<script>
    (function () {
        const toggle = document.getElementById('user-menu-toggle');
        const menu   = document.getElementById('user-menu');

        if (!toggle || !menu) return;

        const openMenu = () => {
            menu.classList.remove('hidden');
            toggle.setAttribute('aria-expanded', 'true');
        };

        const closeMenu = () => {
            menu.classList.add('hidden');
            toggle.setAttribute('aria-expanded', 'false');
        };

        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            if (menu.classList.contains('hidden')) {
                openMenu();
            } else {
                closeMenu();
            }
        });

        menu.addEventListener('click', function (e) {
            e.stopPropagation();
        });

        document.addEventListener('click', function () {
            closeMenu();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeMenu();
        });
    })();
</script>

</body>
</html>
