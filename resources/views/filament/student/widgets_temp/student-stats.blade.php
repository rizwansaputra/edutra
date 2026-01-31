@php($s = $this->getStatsData())

<style>
    .st-grid{ display:grid; grid-template-columns:1fr; gap:14px; }
    @media (min-width:768px){ .st-grid{ grid-template-columns:repeat(3, 1fr); } }

    .st-card{
        background:#fff;
        border-radius:18px;
        border:1px solid #e2e8f0;
        padding:14px;
        box-shadow:0 1px 3px rgba(15,23,42,.08);
        min-height:88px;
        display:flex;
        flex-direction:column;
        justify-content:space-between;
    }

    .st-head{ display:flex; align-items:center; justify-content:space-between; gap:10px; }
    .st-title{ margin:0; font-size:12px; font-weight:800; color:#475569; }
    .st-icon{
        width:34px; height:34px; border-radius:12px;
        background:rgba(255,97,41,.12);
        display:flex; align-items:center; justify-content:center;
        color:#FF6129; flex-shrink:0;
    }

    .st-value{ margin:10px 0 0; font-size:20px; font-weight:900; color:#0f172a; line-height:1.1; }
    .st-value--text{ font-size:13px; font-weight:800; margin-top:10px; }
    .st-desc{ margin:6px 0 0; font-size:12px; color:#64748b; line-height:1.35; }

    /* clamp 2 baris supaya course name gak “meledak” */
    .st-clamp{
        display:-webkit-box;
        -webkit-line-clamp:2;
        -webkit-box-orient:vertical;
        overflow:hidden;
    }
</style>

<div class="st-grid">
    <div class="st-card">
        <div class="st-head">
            <p class="st-title">My Courses</p>
            <div class="st-icon">
                <x-filament::icon icon="heroicon-o-book-open" class="h-4 w-4" />
            </div>
        </div>
        <div>
            <div class="st-value">{{ $s['totalMyCourses'] }}</div>
            <p class="st-desc">Total course yang kamu miliki</p>
        </div>
    </div>

    <div class="st-card">
        <div class="st-head">
            <p class="st-title">7 Hari Terakhir</p>
            <div class="st-icon">
                <x-filament::icon icon="heroicon-o-clock" class="h-4 w-4" />
            </div>
        </div>
        <div>
            <div class="st-value">{{ $s['recentCourses'] }}</div>
            <p class="st-desc">Course baru yang kamu ambil</p>
        </div>
    </div>

    <div class="st-card">
        <div class="st-head">
            <p class="st-title">Terakhir Diambil</p>
            <div class="st-icon">
                <x-filament::icon icon="heroicon-o-play" class="h-4 w-4" />
            </div>
        </div>
        <div>
            <div class="st-value st-value--text st-clamp">{{ $s['lastCourseName'] }}</div>
            <p class="st-desc">Course terakhir kamu</p>
        </div>
    </div>
</div>
