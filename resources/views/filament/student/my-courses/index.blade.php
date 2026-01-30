@php
    /** @var \App\Filament\Student\Resources\MyCourses\Pages\ListMyCourses $this */
    $courses = $this->getCourses();

    $activeTab = request('tab', 'all');
    $base = request()->except('page', 'tab');

    $tabs = [
        'all' => 'All Courses',
        'premium' => 'Premium',
        'starter' => 'Starter',
        'finished' => 'Finished',
    ];
@endphp

@push('styles')
<style>
    /* ====== WRAPPER ====== */
    .mc-wrap{
        /* background:#F5F8FA;
        border:1px solid #E6EAF0;
        border-radius:18px; */
        padding:18px;
    }

    /* ====== HEADER ====== */
    .mc-title{ font-size:22px; font-weight:800; line-height:1.2; }
    .mc-desc{ margin-top:4px; font-size:13px; color:#6D7786; }

    /* ====== SEARCH ROW ====== */
    .mc-search-row{
        display:flex;
        gap:10px;
        margin-top:14px;
        align-items:center;
        flex-wrap:wrap;
    }

    .mc-search{
        flex: 1 1 520px;
        min-width: 260px;
        height:44px;
        background:#fff;
        border:1px solid #D7DDE6;
        border-radius:999px;
        padding:0 14px;
        display:flex;
        align-items:center;
        gap:10px;
        transition:.15s ease;
    }
    .mc-search:focus-within{
        border-color:#3B82F6;
        box-shadow:0 0 0 4px rgba(59,130,246,.12);
    }
    .mc-search svg{ width:16px; height:16px; flex-shrink:0; color:#6D7786; }
    .mc-search input{
        width:100%;
        height:100%;
        border:0;
        outline:none;
        background:transparent;
        font-size:13px;
        line-height:1;
        padding:0;
        color:#111827;
    }

    .mc-actions{
        display:flex;
        gap:10px;
        flex: 0 0 auto;
    }

    .mc-btn{
        height:44px;
        padding:0 16px;
        border-radius:999px;
        font-weight:700;
        font-size:13px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        border:1px solid transparent;
        color:#fff;
        transition:.15s ease;
        white-space:nowrap;
        user-select:none;
    }
    .mc-btn.blue{ background:#1D4ED8; }
    .mc-btn.red{ background:#DC2626; }
    .mc-btn:hover{ filter:brightness(.97); transform:translateY(-1px); }
    .mc-btn:active{ transform:translateY(0); }

    /* ====== TABS ====== */
    .mc-tabs{
        margin-top:12px;
        display:flex;
        flex-wrap:wrap;
        gap:10px;
    }
    .mc-tab{
        height:36px;
        padding:0 14px;
        border-radius:999px;
        font-size:13px;
        font-weight:800;
        background:#E9EEF4;
        color:#111827;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        transition:.15s ease;
        border:1px solid #E1E7F0;
        text-decoration:none;
    }
    .mc-tab.active{
        background:#111827;
        border-color:#111827;
        color:#fff;
    }

    /* ====== GRID ====== */
    .mc-grid{
        margin-top:16px;
        display:grid;
        grid-template-columns: repeat(1, minmax(0, 1fr));
        gap:14px;
    }
    @media (min-width: 640px){
        .mc-grid{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (min-width: 1024px){
        .mc-grid{ grid-template-columns: repeat(3, minmax(0, 1fr)); } /* 3 per baris */
    }

    /* ====== CARD (COMPACT) ====== */
    .mc-card{
        background:#fff;
        border:1px solid #E6EAF0;
        border-radius:16px;
        overflow:hidden;
        transition:.15s ease;
    }
    .mc-card:hover{
        transform:translateY(-2px);
        box-shadow:0 12px 24px rgba(17,24,39,.08);
        border-color: rgba(255,97,41,.55);
    }
    .mc-thumb{
        width:100%;
        /* height:140px;            kunci biar gak kayak banner */
        background:#EEF2F7;
        overflow:hidden;
    }
    .mc-thumb img{
        width:100%;
        /* height:100%; */
        object-fit:cover;
        display:block;
    }
    .mc-body{
        padding:12px;
        display:flex;
        flex-direction:column;
        gap:10px;
    }
    .mc-name{
        font-size:14px;
        font-weight:800;
        line-height:1.25;
        color:#111827;
        text-decoration:none;

        display:-webkit-box;
        -webkit-line-clamp:2;
        -webkit-box-orient:vertical;
        overflow:hidden;
    }
    .mc-meta{
        font-size:12px;
        color:#6D7786;
        margin-top:4px;
    }
    .mc-cta{
        height:36px;
        padding:0 12px;
        border-radius:999px;
        background:#FF6129;
        color:#fff;
        font-size:12px;
        font-weight:800;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        width:fit-content;
        text-decoration:none;
        transition:.15s ease;
        white-space:nowrap;
    }
    .mc-cta:hover{ filter:brightness(.97); transform:translateY(-1px); }

    /* empty state */
    .mc-empty{
        background:#fff;
        border:1px solid #E6EAF0;
        border-radius:16px;
        padding:18px;
        text-align:center;
        color:#6D7786;
        font-size:13px;
        margin-top:16px;
    }
</style>
@endpush

<section class="max-w-[1200px] mx-auto">
    <div class="mc-wrap">

        <div>
            <div class="mc-title">My Courses</div>
            <div class="mc-desc">Upgrade terus ilmu dan pengalaman terbaru kamu di bidang teknologi</div>
        </div>

        {{-- Search + actions --}}
        <form method="GET" class="mc-search-row">
            <div class="mc-search">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M10 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16z"/>
                </svg>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kelas...">
            </div>

            <div class="mc-actions">
                <button type="submit" class="mc-btn blue">Search</button>
                <a href="{{ url()->current() }}" class="mc-btn red">Reset</a>
            </div>
        </form>

        {{-- Tabs --}}
        <div class="mc-tabs">
            @foreach($tabs as $key => $label)
                @php
                    $url = route('filament.student.resources.my-courses.index', array_merge($base, ['tab' => $key]));
                    $isActive = $activeTab === $key;
                @endphp
                <a href="{{ $url }}" class="mc-tab {{ $isActive ? 'active' : '' }}">{{ $label }}</a>
            @endforeach
        </div>

        {{-- Cards --}}
        @if($courses->isEmpty())
            <div class="mc-empty">Belum ada course yang kamu ikuti.</div>
        @else
            <div class="mc-grid">
                @foreach($courses as $course)
                    @php
                        $thumb = $course->thumbnail
                            ? asset('storage/' . $course->thumbnail)
                            : asset('assets/thumbnail/thumbnail-1.png');

                        $labelText = $course->category?->name ? 'Kelas ' . $course->category->name : 'Kelas';

                        $viewUrl = \App\Filament\Student\Resources\MyCourses\MyCourseResource::getUrl('view', ['record' => $course]);
                    @endphp

                    <div class="mc-card">
                        <a href="{{ $viewUrl }}" class="mc-thumb">
                            <img src="{{ $thumb }}" alt="{{ $course->name }}" loading="lazy">
                        </a>

                        <div class="mc-body">
                            <div>
                                <a href="{{ $viewUrl }}" class="mc-name">{{ $course->name }}</a>
                                <div class="mc-meta">{{ $labelText }}</div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $courses->links() }}
            </div>
        @endif

    </div>
</section>
