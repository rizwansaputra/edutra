<x-filament::section>
    <x-slot name="heading">
        Quick Actions
    </x-slot>

    <style>
        .qa-list{ display:flex; flex-direction:column; gap:12px; }

        .qa-item{
            background:#fff;
            border-radius:20px;
            border:1px solid #e2e8f0;
            padding:14px 14px;
            box-shadow:0 1px 3px rgba(15,23,42,.08);
            text-decoration:none;
            transition:.15s ease;
            display:flex;
            align-items:center;
            gap:12px;
        }
        .qa-item:hover{
            border-color:#FF6129;
            background:#fff7f3;
            transform:translateY(-1px);
            box-shadow:0 10px 18px rgba(15,23,42,.10);
        }

        .qa-item__icon{
            width:44px; height:44px; border-radius:14px;
            background:rgba(255,97,41,.12);
            display:flex; align-items:center; justify-content:center;
            flex-shrink:0;
            color:#FF6129;
        }

        .qa-item__content{ min-width:0; flex:1; }
        .qa-item__title{
            margin:0;
            font-size:14px;
            font-weight:800;
            color:#0f172a;
            line-height:1.2;
        }
        .qa-item__desc{
            margin:6px 0 0;
            font-size:12px;
            color:#64748b;
            line-height:1.35;

            /* biar rapi, maksimal 2 baris */
            display:-webkit-box;
            -webkit-line-clamp:2;
            -webkit-box-orient:vertical;
            overflow:hidden;
        }

        .qa-item__arrow{
            width:34px; height:34px; border-radius:999px;
            border:1px solid #e2e8f0;
            display:flex; align-items:center; justify-content:center;
            color:#111827;
            transition:.15s ease;
            flex-shrink:0;
        }
        .qa-item:hover .qa-item__arrow{
            border-color:#FF6129;
            color:#FF6129;
            background:rgba(255,97,41,.10);
        }

        /* Responsive: padding lebih rapat di mobile */
        @media (max-width:640px){
            .qa-item{ padding:12px; border-radius:18px; }
            .qa-item__icon{ width:40px; height:40px; border-radius:12px; }
        }
    </style>

    <div class="qa-list">
        {{-- Browse Courses --}}
        <a href="{{ route('courses.index') }}" class="qa-item">
            <div class="qa-item__icon">
                <x-filament::icon icon="heroicon-o-magnifying-glass" class="h-5 w-5" />
            </div>
            <div class="qa-item__content">
                <p class="qa-item__title">Browse Courses</p>
                <p class="qa-item__desc">Cari kelas baru dan mulai belajar hari ini.</p>
            </div>
            <div class="qa-item__arrow" aria-hidden="true">→</div>
        </a>

        {{-- My Courses --}}
        <a href="{{ url('/student/my-courses') }}" class="qa-item">
            <div class="qa-item__icon">
                <x-filament::icon icon="heroicon-o-book-open" class="h-5 w-5" />
            </div>
            <div class="qa-item__content">
                <p class="qa-item__title">My Courses</p>
                <p class="qa-item__desc">Lanjutkan course yang sudah kamu ambil.</p>
            </div>
            <div class="qa-item__arrow" aria-hidden="true">→</div>
        </a>

        {{-- Settings --}}
        <a href="{{ url('/student/settings') }}" class="qa-item">
            <div class="qa-item__icon">
                <x-filament::icon icon="heroicon-o-cog-6-tooth" class="h-5 w-5" />
            </div>
            <div class="qa-item__content">
                <p class="qa-item__title">Settings</p>
                <p class="qa-item__desc">Kelola profil, email, dan password akun.</p>
            </div>
            <div class="qa-item__arrow" aria-hidden="true">→</div>
        </a>
    </div>
</x-filament::section>
