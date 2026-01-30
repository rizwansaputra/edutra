<x-filament-panels::page>
    @php
        /** @var \App\Models\Course $course */

        $videos = $course->videos()->orderBy('id')->get();

        $videoId = request('video');
        $currentVideo = $videos->firstWhere('id', (int) $videoId) ?? $videos->first();

        $currentIndex = $currentVideo
            ? $videos->search(fn ($v) => $v->id === $currentVideo->id)
            : null;

        $nextVideo = ($currentIndex !== null && $currentIndex !== false)
            ? ($videos[$currentIndex + 1] ?? null)
            : null;

        $baseUrl = url()->current();

        // URL tujuan saat selesai (list my courses)
        $finishUrl = url('/student/my-courses');
        // Kalau kamu punya named route list, lebih bagus:
        // $finishUrl = route('filament.student.resources.my-courses.index');
    @endphp

    <style>
        .course-view {
            min-height: 70vh;
            background: #f5f7fb;
            margin: -1.5rem -1.5rem 0;
            padding: 1.5rem;
        }
        .course-view__container { max-width: 1120px; margin: 0 auto; }

        .course-view__top{ display:flex; justify-content:space-between; align-items:center; gap:24px; margin-bottom:24px; }
        .course-view__top-left{ display:flex; align-items:center; gap:12px; }

        .course-view__back-btn{
            width:36px;height:36px;border-radius:999px;border:1px solid #e2e8f0;background:#fff;
            display:flex;align-items:center;justify-content:center;cursor:pointer;
            box-shadow:0 1px 2px rgba(15,23,42,.06);text-decoration:none;
        }
        .course-view__back-btn span{ font-size:18px; line-height:1; color:#0f172a; }

        .course-view__subtitle{ font-size:11px;text-transform:uppercase;letter-spacing:.18em;color:#94a3b8;font-weight:600;margin:0 0 4px; }
        .course-view__title{ margin:0;font-size:18px;font-weight:600;color:#0f172a; }

        .course-view__layout{ display:flex; flex-direction:column; gap:24px; }
        @media (min-width:1024px){ .course-view__layout{ flex-direction:row; align-items:flex-start; } }

        .course-view__sidebar{ width:100%; max-width:320px; flex-shrink:0; }
        .course-view__sidebar-card{
            background:#fff;border-radius:24px;border:1px solid #e2e8f0;padding:16px;
            box-shadow:0 1px 3px rgba(15,23,42,.08);
        }

        .course-view__playlist-card{ background:#f8fafc;border-radius:18px;padding:14px; }
        .course-view__playlist-header{ display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; }
        .course-view__playlist-title{ font-size:11px;text-transform:uppercase;letter-spacing:.18em;color:#9ca3af;font-weight:600;margin:0 0 2px; }
        .course-view__playlist-count{ margin:0;font-size:14px;font-weight:600;color:#0f172a; }
        .course-view__playlist-est{ font-size:11px;color:#6b7280; }

        .course-view__playlist-list{ max-height:420px; overflow-y:auto; padding-right:4px; }

        .course-view__playlist-item{
            display:flex;align-items:center;gap:10px;border-radius:999px;padding:8px 10px;margin-bottom:6px;
            text-decoration:none;font-size:13px;transition:background .15s ease,color .15s ease;
        }
        .course-view__playlist-item:last-child{ margin-bottom:0; }
        .course-view__playlist-item--active{ background:#111827; color:#f9fafb; }
        .course-view__playlist-item--inactive{ background:#fff; color:#111827; }
        .course-view__playlist-item--inactive:hover{ background:#e5e7eb; }

        .course-view__playlist-play{
            width:26px;height:26px;border-radius:999px;display:flex;align-items:center;justify-content:center;
            font-size:14px;flex-shrink:0;
        }
        .course-view__playlist-item--active .course-view__playlist-play{ background:#111827; color:#f9fafb; }
        .course-view__playlist-item--inactive .course-view__playlist-play{ background:#e5e7eb; color:#111827; }

        .course-view__playlist-text{ flex:1; min-width:0; }
        .course-view__playlist-name{ margin:0;font-size:13px;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis; }
        .course-view__playlist-meta{ margin:2px 0 0;font-size:11px;color:inherit;opacity:.7; }
        .course-view__playlist-status{
            width:18px;height:18px;border-radius:999px;background:#22c55e;color:#fff;font-size:10px;
            display:flex;align-items:center;justify-content:center;flex-shrink:0;
        }

        .course-view__main{ flex:1; }
        .course-view__video-card{
            background:#fff;border-radius:24px;border:1px solid #e2e8f0;box-shadow:0 1px 3px rgba(15,23,42,.08);
            overflow:hidden;
        }
        .course-view__video-wrapper{ background:#000; position:relative; padding-top:56.25%; }
        .course-view__video-wrapper iframe{ position:absolute; inset:0; width:100%; height:100%; border:0; }
        .course-view__video-empty{ background:#e5e7eb; padding:40px 16px; text-align:center; font-size:14px; color:#6b7280; }

        .course-view__video-footer{ border-top:1px solid #e5e7eb; padding:14px 18px 18px; }
        .course-view__video-title{ margin:0; font-size:16px; font-weight:600; color:#111827; }
        .course-view__video-desc{ margin:4px 0 0; font-size:13px; color:#6b7280; }

        .course-view__actions{ margin-top:14px; display:flex; justify-content:flex-end; gap:10px; }

        .course-view__next-btn{
            height:40px;padding:0 16px;border-radius:999px;background:#FF6129;color:#fff;font-weight:700;font-size:13px;
            display:inline-flex;align-items:center;justify-content:center;text-decoration:none;transition:.15s ease;white-space:nowrap;
        }
        .course-view__next-btn:hover{ filter:brightness(.97); transform:translateY(-1px); box-shadow:0 10px 18px rgba(255,97,41,.22); }

        .course-view__finish-link{
            height:40px;padding:0 16px;border-radius:999px;background:#22c55e;color:#fff;font-weight:700;font-size:13px;
            display:inline-flex;align-items:center;justify-content:center;text-decoration:none;white-space:nowrap;
        }
        .course-view__finish-link:hover{ filter:brightness(.97); transform:translateY(-1px); box-shadow:0 10px 18px rgba(34,197,94,.22); }

        @media (max-width:767px){
            .course-view{ margin-top:-1rem; padding:1rem; }
            .course-view__top{ align-items:flex-start; }
        }
    </style>

    <div class="course-view">
        <div class="course-view__container">

            {{-- TOP BAR --}}
            <div class="course-view__top">
                <div class="course-view__top-left">
                    <a href="{{ url()->previous() }}" class="course-view__back-btn">
                        <span>&larr;</span>
                    </a>
                    <div>
                        <p class="course-view__subtitle">My Course</p>
                        <h1 class="course-view__title">{{ $course->name }}</h1>
                    </div>
                </div>
            </div>

            {{-- MAIN LAYOUT --}}
            <div class="course-view__layout">

                {{-- SIDEBAR / PLAYLIST --}}
                <div class="course-view__sidebar">
                    <div class="course-view__sidebar-card">
                        <div class="course-view__playlist-card">
                            <div class="course-view__playlist-header">
                                <div>
                                    <p class="course-view__playlist-title">Playlist</p>
                                    <p class="course-view__playlist-count">{{ $videos->count() }} video</p>
                                </div>

                                @if ($videos->count())
                                    <span class="course-view__playlist-est">
                                        Est. {{ $videos->count() * 5 }} menit
                                    </span>
                                @endif
                            </div>

                            <div class="course-view__playlist-list">
                                @forelse ($videos as $index => $video)
                                    @php
                                        $isCurrent = $currentVideo && $video->id === $currentVideo->id;
                                        $videoUrl = $baseUrl . '?video=' . $video->id;
                                    @endphp

                                    <a href="{{ $videoUrl }}"
                                       class="course-view__playlist-item {{ $isCurrent ? 'course-view__playlist-item--active' : 'course-view__playlist-item--inactive' }}">
                                        <div class="course-view__playlist-play">►</div>

                                        <div class="course-view__playlist-text">
                                            <p class="course-view__playlist-name">{{ $video->name }}</p>
                                            <p class="course-view__playlist-meta">{{ $index + 1 }} • Video pelajaran</p>
                                        </div>

                                        @if ($isCurrent)
                                            <div class="course-view__playlist-status">✓</div>
                                        @endif
                                    </a>
                                @empty
                                    <p style="font-size:12px;color:#6b7280;">Belum ada video untuk kelas ini.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- MAIN VIDEO AREA --}}
                <div class="course-view__main">
                    <div class="course-view__video-card">
                        @if ($currentVideo && $currentVideo->embed_url)
                            <div class="course-view__video-wrapper">
                                <iframe
                                    src="{{ $currentVideo->embed_url }}"
                                    title="{{ $currentVideo->name }}"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen
                                ></iframe>
                            </div>
                        @else
                            <div class="course-view__video-empty">
                                Belum ada video atau URL YouTube tidak valid untuk kelas ini.
                            </div>
                        @endif

                        <div class="course-view__video-footer">
                            <h2 class="course-view__video-title">
                                {{ $currentVideo?->name ?? 'Video belum tersedia' }}
                            </h2>

                            @if ($currentVideo?->description)
                                <p class="course-view__video-desc">{{ $currentVideo->description }}</p>
                            @endif

                            <div class="course-view__actions">
                                @if ($nextVideo)
                                    <a href="{{ $baseUrl }}?video={{ $nextVideo->id }}" class="course-view__next-btn">
                                        Next Video →
                                    </a>
                                @else
                                    <a href="{{ $finishUrl }}" class="course-view__finish-link">
                                        ✓ Selesai
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</x-filament-panels::page>
