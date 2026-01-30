<x-filament-panels::page>
    @php $user = auth()->user(); @endphp

    <style>
        .settings-page{
            min-height: 70vh;
            background: #f5f7fb;
            margin: -1.5rem -1.5rem 0;
            padding: 1.5rem;
        }
        .settings-page__container{ max-width:1120px; margin:0 auto; }

        .settings-page__head{ display:flex; justify-content:space-between; align-items:flex-end; gap:16px; margin-bottom:18px; }
        .settings-page__title{ margin:0; font-size:18px; font-weight:700; color:#0f172a; }
        .settings-page__desc{ margin:6px 0 0; font-size:13px; color:#64748b; }

        .settings-layout{ display:flex; flex-direction:column; gap:24px; }
        @media (min-width:1024px){ .settings-layout{ flex-direction:row; align-items:flex-start; } }

        .settings-left{ width:100%; max-width:360px; flex-shrink:0; }
        .settings-card{
            background:#fff;border-radius:24px;border:1px solid #e2e8f0;padding:16px;
            box-shadow:0 1px 3px rgba(15,23,42,.08);
        }

        .profile-top{ display:flex; justify-content:space-between; align-items:center; gap:12px; }
        .profile-title{ margin:0; font-size:14px; font-weight:700; color:#0f172a; }
        .badge-pro{
            padding:4px 10px; border-radius:999px; background:#FF6129; color:#fff;
            font-weight:700; font-size:11px;
        }

        .profile-user{ display:flex; align-items:center; gap:12px; margin-top:14px; }
        .avatar{ width:56px; height:56px; border-radius:999px; overflow:hidden; background:#e5e7eb; flex-shrink:0; }
        .avatar img{ width:100%; height:100%; object-fit:cover; }
        .profile-name{ margin:0; font-size:13px; font-weight:700; color:#0f172a; }
        .profile-sub{ margin:2px 0 0; font-size:12px; color:#64748b; }

        .divider{ height:1px; background:#e5e7eb; margin:14px 0; }

        .info-row{ display:flex; gap:10px; align-items:center; }
        .info-icon{
            width:22px; height:22px; border-radius:999px; background:#e5e7eb; color:#111827;
            display:flex; align-items:center; justify-content:center; font-size:12px; flex-shrink:0;
        }
        .info-text{ margin:0; font-size:13px; color:#334155; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }

        .back-btn{
            margin-top:14px;
            height:42px; border-radius:999px; border:1px solid #111827; background:#fff; color:#111827;
            font-weight:700; font-size:13px;
            display:flex; align-items:center; justify-content:center;
            text-decoration:none; transition:.15s ease;
        }
        .back-btn:hover{ background:#111827; color:#fff; }

        .settings-right{ flex:1; }
        .form-head{ display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom:10px; }
        .form-title{ margin:0; font-size:14px; font-weight:700; color:#0f172a; }
        .form-hint{ font-size:11px; color:#94a3b8; }

        .grid-2{ display:grid; grid-template-columns:1fr; gap:14px; }
        @media (min-width:768px){ .grid-2{ grid-template-columns:1fr 1fr; } }

        .field{ display:flex; flex-direction:column; gap:6px; }
        .label{ font-size:12px; font-weight:700; color:#475569; }
        .input{
            height:44px; padding:0 14px; border-radius:999px; border:1px solid #e2e8f0;
            outline:none; font-size:13px; color:#0f172a; background:#fff;
            transition:.15s ease;
        }
        .input:focus{
            border-color:#FF6129;
            box-shadow:0 0 0 4px rgba(255,97,41,.18);
        }
        .error{ margin:0; font-size:12px; color:#dc2626; }

        .section-title{ margin:0; font-size:14px; font-weight:800; color:#0f172a; }
        .section-desc{ margin:6px 0 0; font-size:12px; color:#64748b; }

        .actions{ margin-top:14px; display:flex; justify-content:flex-end; }
        .save-btn{
            height:44px; padding:0 18px; border-radius:999px; background:#FF6129; color:#fff;
            font-weight:800; font-size:13px; border:0; cursor:pointer; transition:.15s ease;
        }
        .save-btn:hover{ filter:brightness(.97); transform:translateY(-1px); box-shadow:0 10px 18px rgba(255,97,41,.22); }

        @media (max-width:767px){
            .settings-page{ margin-top:-1rem; padding:1rem; }
        }
    </style>

    <div class="settings-page">
        <div class="settings-page__container">

            <div class="settings-page__head">
                <div>
                    <h1 class="settings-page__title">Account Settings</h1>
                    <p class="settings-page__desc">Update profile information and change your password.</p>
                </div>
            </div>

            @if(! $user)
                <div class="settings-card">
                    <p style="margin:0;color:#b91c1c;font-weight:700;">You are not authenticated. Please login again.</p>
                </div>
            @else
                <div class="settings-layout">
                    {{-- LEFT --}}
                    <div class="settings-left">
                        <div class="settings-card">
                            <div class="profile-top">
                                <p class="profile-title">My Profile</p>
                                <span class="badge-pro">PRO</span>
                            </div>

                            <div class="profile-user">
                                <div class="avatar">
                                    <img src="{{ asset('assets/photo/photo5.png') }}" alt="photo">
                                </div>

                                <div style="min-width:0;">
                                    <p class="profile-name">{{ $user->name }}</p>
                                    <p class="profile-sub">Verified Member</p>
                                </div>
                            </div>

                            <div class="divider"></div>

                            <div class="info-row">
                                <div class="info-icon">✓</div>
                                <p class="info-text">{{ $user->email }}</p>
                            </div>

                            <a href="{{ url('/student/my-courses') }}" class="back-btn">
                                Back to My Courses
                            </a>
                        </div>
                    </div>

                    {{-- RIGHT --}}
                    <div class="settings-right">
                        <form wire:submit.prevent="save" class="settings-card">
                            <div class="form-head">
                                <p class="form-title">Update Information</p>
                                <span class="form-hint">Last updated: {{ now()->format('d M Y') }}</span>
                            </div>

                            <div class="grid-2">
                                <div class="field">
                                    <label class="label">Full Name</label>
                                    <input type="text" wire:model.defer="data.name" class="input" placeholder="Your name">
                                    @error('data.name') <p class="error">{{ $message }}</p> @enderror
                                </div>

                                <div class="field">
                                    <label class="label">Email Address</label>
                                    <input type="email" wire:model.defer="data.email" class="input" placeholder="you@example.com">
                                    @error('data.email') <p class="error">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="divider"></div>

                            <p class="section-title">Security Password</p>
                            <p class="section-desc">Leave empty if you don’t want to change it.</p>

                            <div class="grid-2" style="margin-top:12px;">
                                <div class="field">
                                    <label class="label">New Password</label>
                                    <input type="password" wire:model.defer="data.password" class="input" placeholder="********">
                                    @error('data.password') <p class="error">{{ $message }}</p> @enderror
                                </div>

                                <div class="field">
                                    <label class="label">Confirm Password</label>
                                    <input type="password" wire:model.defer="data.password_confirmation" class="input" placeholder="********">
                                </div>
                            </div>

                            <div class="actions">
                                <button type="submit" class="save-btn" wire:loading.attr="disabled">
                                    <span wire:loading.remove>Save Changes</span>
                                    <span wire:loading>Saving...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-filament-panels::page>
