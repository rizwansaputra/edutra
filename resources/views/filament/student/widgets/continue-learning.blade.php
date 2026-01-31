<x-filament::section>
    <x-slot name="heading">
        Lanjutkan Belajar
    </x-slot>

    <style>
        .cl-list{ display:flex; flex-direction:column; gap:12px; }

        .cl-item{
            background:#fff;
            border-radius:20px;
            border:1px solid #e2e8f0;
            padding:14px;
            box-shadow:0 1px 3px rgba(15,23,42,.08);
            display:flex;
            align-items:center;
            gap:12px;
            transition:.15s ease;
        }
        .cl-item:hover{
            border-color:#FF6129;
            background:#fff7f3;
            transform:translateY(-1px);
            box-shadow:0 10px 18px rgba(15,23,42,.10);
        }

        .cl-icon{
            width:44px;height:44px;border-radius:14px;
            background:rgba(255,97,41,.12);
            display:flex;align-items:center;justify-content:center;
            color:#FF6129;
            flex-shrink:0;
        }

        .cl-content{ min-width:0; flex:1; }
        .cl-title{
            margin:0;
            font-size:14px;
            font-weight:800;
            color:#0f172a;
            line-height:1.25;
        }
        .cl-desc{
            margin:6px 0 0;
            font-size:12px;
            color:#64748b;
        }

        .cl-action{
            height:34px;
            padding:0 14px;
            border-radius:999px;
            border:1px solid #FF6129;
            background:#FF6129;
            color:#fff;
            font-size:12px;
            font-weight:800;
            text-decoration:none;
            display:flex;
            align-items:center;
            transition:.15s ease;
            white-space:nowrap;
        }
        .cl-action:hover{
            filter:brightness(.97);
            transform:translateY(-1px);
            box-shadow:0 8px 16px rgba(255,97,41,.22);
        }

        .cl-footer{
            margin-top:14px;
            display:flex;
            justify-content:flex-end;
        }

        .cl-empty{
            font-size:13px;
            color:#64748b;
        }

        .cl-browse{
            margin-top:12px;
            height:40px;
            padding:0 18px;
            border-radius:999px;
            border:1px solid #111827;
            background:#fff;
            color:#111827;
            font-weight:800;
            font-size:13px;
            display:inline-flex;
            align-items:center;
            text-decoration:none;
            transition:.15s ease;
        }
        .cl-browse:hover{
            background:#111827;
            color:#fff;
        }

        @media (max-width:640px){
            .cl-item{ padding:12px; border-radius:18px; }
            .cl-icon{ width:40px; height:40px; border-radius:12px; }
        }
    </style>

    @php($courses = $this->getCourses())

    @if($courses->isEmpty())
        <p class="cl-empty">
            Kamu belum punya course. Yuk mulai belajar!
        </p>

        <a href="{{ route('courses.index') }}" class="cl-browse">
            Browse Courses
        </a>
    @else
        <div class="cl-list">
            @foreach($courses as $course)
                <div class="cl-item">
                    <div class="cl-icon">
                        <x-filament::icon icon="heroicon-o-play" class="h-5 w-5" />
                    </div>

                    <div class="cl-content">
                        <p class="cl-title">{{ $course->name }}</p>
                        <p class="cl-desc">Lanjutkan pembelajaran course ini</p>
                    </div>

                    <a href="{{ url('/student/my-courses/' . $course->id) }}"
                       class="cl-action">
                        Lanjut
                    </a>
                </div>
            @endforeach
        </div>

        <div class="cl-footer">
            <a href="{{ url('/student/my-courses') }}" class="cl-browse">
                Lihat Semua My Courses
            </a>
        </div>
    @endif
</x-filament::section>
