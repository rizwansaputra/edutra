{{-- resources/views/courses/checkout.blade.php --}}
@extends('layouts.front')

@section('title', 'Checkout – Free Plan')

@section('content')
    <div id="checkout-section"
         class="max-w-[1200px] mx-auto w-full min-h-[calc(100vh-40px)] flex flex-col gap-[30px]
                bg-[url('{{ asset('assets/background/Hero-Banner.png') }}')]
                bg-center bg-no-repeat bg-cover rounded-t-[32px] overflow-hidden relative pb-6 mt-10">

        {{-- BAGIAN TITLE --}}
        <div class="flex flex-col gap-[10px] items-center mt-10">
            <div class="gradient-badge w-fit p-[8px_16px] rounded-full border border-[#FED6AD]
                        flex items-center gap-[6px] bg-white/80">
                <div>
                    <img src="{{ asset('assets/icon/medal-star.svg') }}" alt="icon">
                </div>
                <p class="font-medium text-sm text-[#FF6129]">Start Your Journey For Free</p>
            </div>
            <h2 class="font-bold text-[40px] leading-[60px] text-white">
                Checkout – Free Plan
            </h2>
        </div>

        {{-- FLASH SUCCESS --}}
        @if(session('success'))
            <div class="px-[100px] mt-4">
                <div class="mb-4 p-4 rounded-xl bg-green-100 text-green-800">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        {{-- KONTEN --}}
        <div class="flex flex-col lg:flex-row gap-10 px-[100px] relative z-10 mt-6">
            {{-- CARD PAKET --}}
            <div class="w-full lg:w-[400px] flex shrink-0 flex-col bg-white rounded-2xl p-5 gap-4 h-fit">
                <p class="font-bold text-lg">Package</p>
                <div class="flex items-center justify-between w-full">
                    <div class="flex items-center gap-3">
                        <div class="w-[50px] h-[50px] flex shrink-0 rounded-full overflow-hidden">
                            <img src="{{ asset('assets/icon/Web Development 1.svg') }}"
                                 class="w-full h-full object-cover" alt="icon">
                        </div>
                        <div class="flex flex-col gap-[2px]">
                            <p class="font-semibold">
                                Free Plan
                            </p>
                            <p class="text-sm text-[#6D7786]">
                                7 days access
                            </p>
                        </div>
                    </div>
                    <p class="p-[4px_12px] rounded-full bg-[#16A34A] font-semibold text-xs text-white text-center">
                        Free
                    </p>
                </div>
                <hr>
                <div class="flex flex-col gap-5">
                    <div class="flex gap-3">
                        <div class="w-6 h-6 flex shrink-0">
                            <img src="{{ asset('assets/icon/tick-circle.svg') }}" class="w-full h-full object-cover" alt="icon">
                        </div>
                        <p class="text-[#475466]">Access selected free courses</p>
                    </div>
                    <div class="flex gap-3">
                        <div class="w-6 h-6 flex shrink-0">
                            <img src="{{ asset('assets/icon/tick-circle.svg') }}" class="w-full h-full object-cover" alt="icon">
                        </div>
                        <p class="text-[#475466]">Start learning without any payment</p>
                    </div>
                    <div class="flex gap-3">
                        <div class="w-6 h-6 flex shrink-0">
                            <img src="{{ asset('assets/icon/tick-circle.svg') }}" class="w-full h-full object-cover" alt="icon">
                        </div>
                        <p class="text-[#475466]">Upgrade to Premium anytime</p>
                    </div>
                </div>
                <p class="font-semibold text-[28px] leading-[42px]">
                    Rp 0
                </p>
            </div>

            {{-- FORM CHECKOUT GRATIS --}}
            <form
                class="w-full flex flex-col bg-white rounded-2xl p-5 gap-5"
                method="POST"
                action="{{ route('checkout.free.store', $course) }}"
            >
                @csrf

                <p class="font-bold text-lg">Confirm Your Plan</p>

                <p class="text-[#475466] leading-[28px]">
                    Kamu akan mengaktifkan <span class="font-semibold">Free Plan</span>
                    selama <span class="font-semibold">7 hari</span> untuk course:
                </p>

                <div class="mt-2 p-3 rounded-xl bg-[#F5F8FA]">
                    <p class="font-semibold">{{ $course->name }}</p>
                    <p class="text-sm text-[#6D7786]">
                        Category: {{ $course->category->name ?? 'General' }}
                    </p>
                </div>

                <div class="flex items-center gap-3 mt-4">
                    <div class="w-[40px] h-[40px] rounded-full overflow-hidden flex shrink-0">
                        <img src="{{ asset('assets/photo/photo5.png') }}" class="w-full h-full object-cover" alt="avatar">
                    </div>
                    <div class="flex flex-col">
                        <p class="font-semibold">{{ auth()->user()->name ?? 'Guest' }}</p>
                        <p class="text-sm text-[#6D7786]">{{ auth()->user()->email ?? '-' }}</p>
                    </div>
                </div>

                <hr class="my-4">

                <p class="font-semibold text-[#111827]">
                    Tidak ada pembayaran yang dibutuhkan untuk paket ini.
                </p>
                <p class="text-sm text-[#6B7280]">
                    Dengan menekan tombol di bawah, akses course akan langsung aktif di akunmu
                    (Free Plan – 7 hari).
                </p>

                {{-- data tambahan kalau perlu --}}
                <input type="hidden" name="plan_name" value="Free Plan">
                <input type="hidden" name="duration_days" value="7">

                <button
                    type="submit"
                    class="mt-4 p-[16px_32px] bg-[#FF6129] text-white rounded-full text-center font-semibold
                           transition-all duration-300 hover:shadow-[0_10px_20px_0_#FF612980]"
                >
                    Activate Free Plan
                </button>

                <a
                    href="{{ route('courses.show', $course->slug) }}"
                    class="text-center mt-2 text-sm text-[#6D7786] hover:text-[#FF6129] transition-all duration-300"
                >
                    Batal, kembali ke halaman course
                </a>
            </form>
        </div>

    </div>
@endsection
