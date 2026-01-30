<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Pastikan path asset CSS benar --}}
    <link href="{{ asset('output.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
</head>

<body class="text-black font-poppins pt-10">
    <div id="checkout-section" 
         class="max-w-[1200px] mx-auto w-full min-h-[calc(100vh-40px)] flex flex-col gap-[30px] bg-center bg-no-repeat bg-cover rounded-t-[32px] overflow-hidden relative pb-6"
         style="background-image: url('{{ asset('assets/background/Hero-Banner.png') }}');">
        
        {{-- NAVBAR --}}
        <nav class="flex justify-between items-center pt-6 px-[50px] relative z-20">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/logo/logo.png') }}" alt="logo">
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
                    <button id="user-menu-toggle" class="w-[56px] h-[56px] overflow-hidden rounded-full flex shrink-0 border border-white/20">
                        <img src="{{ asset('assets/photo/photo5.png') }}" class="w-full h-full object-cover" alt="photo">
                    </button>
                    <div id="user-menu" style="width: 130px;padding: 11px 10px 10px 5px;" class="hidden absolute right-0 top-[70px] flex flex-col w-48 bg-white rounded-2xl shadow-xl py-2 z-50 overflow-hidden text-black">
                        <a href="{{ route('my-courses.index') }}" class="px-4 py-3 text-sm hover:bg-gray-50 transition">My Courses</a>
                        <a href="{{ route('settings.edit') }}" class="px-4 py-3 text-sm text-[#FF6129] font-bold">Settings</a>
                        <form method="POST" action="{{ url('/logout') }}" class="border-t border-gray-100">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
            @endauth
        </nav>

        {{-- BADGE & TITLE --}}
        <div class="flex flex-col gap-[10px] items-center relative z-10">
            <div class="gradient-badge w-fit p-[8px_16px] rounded-full border border-[#FED6AD] flex items-center gap-[6px] bg-white">
                <img src="{{ asset('assets/icon/medal-star.svg') }}" alt="icon">
                <p class="font-medium text-sm text-[#FF6129]">Invest In Yourself Today</p>
            </div>
            <h2 class="font-bold text-[40px] leading-[60px] text-white">Account Settings</h2>
        </div>

        {{-- WRAPPER UTAMA UNTUK DUA KOLOM (PROFILE & FORM) --}}
        <div class="flex gap-10 px-[100px] relative z-10 mb-20">
            
            {{-- KOLOM KIRI: CARD PROFILE (MY COURSES) --}}
            <div class="w-[400px] flex shrink-0 flex-col bg-white rounded-2xl p-5 gap-4 h-fit">
                <p class="font-bold text-lg">My Profile</p>
                <div class="flex items-center justify-between w-full">
                    <div class="flex items-center gap-3">
                        <div class="w-[50px] h-[50px] flex shrink-0 rounded-full overflow-hidden">
                            <img src="{{ asset('assets/photo/photo5.png') }}" class="w-full h-full object-cover" alt="photo">
                        </div>
                        <div class="flex flex-col gap-[2px]">
                            <p class="font-semibold truncate w-[140px]">{{ auth()->user()->name }}</p>
                            <p class="text-sm text-[#6D7786]">Verified Member</p>
                        </div>
                    </div>
                    <p class="p-[4px_12px] rounded-full bg-[#FF6129] font-semibold text-xs text-white text-center">PRO</p>
                </div>
                <hr class="border-[#E7EEF2]">
                <div class="flex flex-col gap-5">
                    <div class="flex gap-3">
                        <div class="w-6 h-6 flex shrink-0">
                            <img src="{{ asset('assets/icon/tick-circle.svg') }}" class="w-full h-full object-cover" alt="icon">
                        </div>
                        <p class="text-[#475466] text-sm truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                {{-- Tombol Navigasi ke My Courses --}}
                <a href="{{ route('my-courses.index') }}" class="p-3 border border-black rounded-full text-center font-semibold text-sm hover:bg-black hover:text-white transition-all">
                    Back to My Courses
                </a>
            </div>

            {{-- KOLOM KANAN: FORM SETTINGS --}}
            <form action="{{ route('settings.update') }}" method="POST" class="w-full flex flex-col bg-white rounded-2xl p-5 gap-5 shadow-sm">
                @csrf
                <p class="font-bold text-lg">Update Information</p>
                <div class="flex flex-col gap-5">
                    <div class="flex flex-col gap-2">
                        <label class="font-semibold text-sm text-[#475466]">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                            class="p-4 rounded-full w-full ring-1 ring-black focus:ring-2 focus:ring-[#FF6129] outline-none transition-all">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-semibold text-sm text-[#475466]">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                            class="p-4 rounded-full w-full ring-1 ring-black focus:ring-2 focus:ring-[#FF6129] outline-none transition-all">
                    </div>
                </div>
                <hr class="border-[#E7EEF2]">
                <p class="font-bold text-lg text-[#475466]">Security Password</p>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="font-semibold text-sm">New Password</label>
                        <input type="password" name="password" placeholder="********" class="p-4 rounded-full w-full ring-1 ring-black outline-none transition-all">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-semibold text-sm">Confirm Password</label>
                        <input type="password" name="password_confirmation" placeholder="********" class="p-4 rounded-full w-full ring-1 ring-black outline-none transition-all">
                    </div>
                </div>
                <button type="submit" class="p-[20px_32px] bg-[#FF6129] text-white rounded-full text-center font-semibold transition-all duration-300 hover:shadow-[0_10px_20px_0_#FF612980]">
                    Save Changes
                </button>
            </form>
        </div>

        {{-- LOGO BACKGROUND DI BAWAH --}}
        <div class="flex justify-center absolute transform -translate-x-1/2 left-1/2 bottom-0 w-full z-0 pointer-events-none">
            <img src="{{ asset('assets/background/alqowy.svg') }}" alt="background">
        </div>
    </div>

    <script>
        // Script untuk Dropdown Profile
        const toggle = document.getElementById('user-menu-toggle');
        const menu = document.getElementById('user-menu');
        if (toggle && menu) {
            toggle.addEventListener('click', (e) => {
                e.stopPropagation();
                menu.classList.toggle('hidden');
            });
            document.addEventListener('click', () => menu.classList.add('hidden'));
        }
    </script>
</body>
</html>