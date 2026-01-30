@php
    /** @var \App\Models\Course $course */
    /** @var string $viewUrl */

    $thumb = $course->thumbnail
        ? asset('storage/' . $course->thumbnail)
        : asset('assets/thumbnail/thumbnail-1.png');

    $label = $course->category?->name ? 'Kelas ' . $course->category->name : 'Kelas';
@endphp

<style>
    /* ===== CARD SIZE TUNED FOR col-md-4 ===== */

    .course-card{
        background:#fff;
        border:1px solid #E5E7EB;
        border-radius:14px;
        overflow:hidden;
        transition:.2s ease;
    }

    .course-card:hover{
        transform: translateY(-2px);
        box-shadow:0 8px 18px rgba(0,0,0,.06);
    }

    .course-thumb img{
        width:100%;
        height:120px; /* DIPERKECIL KHUSUS col-md-4 */
        object-fit:cover;
        display:block;
    }

    .course-body{
        padding:12px; /* lebih kecil */
        display:flex;
        flex-direction:column;
        gap:8px;
    }

    .course-title{
        font-size:14px; /* dari 16+ */
        font-weight:700;
        line-height:1.3;
        color:#111827;

        display:-webkit-box;
        -webkit-line-clamp:2;
        -webkit-box-orient:vertical;
        overflow:hidden;
        text-decoration:none;
    }

    .course-sub{
        font-size:11px;
        color:#6B7280;
    }

    .pill-btn{
        margin-top:4px;
        height:34px;
        padding:0 12px;
        border-radius:999px;
        font-size:12px;
        font-weight:600;

        display:inline-flex;
        align-items:center;
        justify-content:center;

        background:#FF6129;
        color:#fff;
        text-decoration:none;
        width:fit-content;
    }

    .pill-btn:hover{
        filter:brightness(.95);
    }
</style>

<div class="course-card">
    <a href="{{ $viewUrl }}">
        <img src="{{ $thumb }}" alt="{{ $course->name }}">
    </a>

    <div class="course-body">
        <div>
            <a href="{{ $viewUrl }}" class="course-title">
                {{ $course->name }}
            </a>
            <div class="course-sub">{{ $label }}</div>
        </div>

        <a href="{{ $viewUrl }}" class="pill-btn">
            Continue
        </a>
    </div>
</div>
