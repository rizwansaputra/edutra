<x-filament-panels::page>
    @php $user = auth()->user(); @endphp

    <style>
        .trx-page{min-height:70vh;background:#f5f7fb;margin:-1.5rem -1.5rem 0;padding:1.5rem;}
        .trx-container{max-width:1120px;margin:0 auto;}
        .trx-head{display:flex;justify-content:space-between;align-items:flex-end;gap:16px;margin-bottom:18px;}
        .trx-title{margin:0;font-size:18px;font-weight:800;color:#0f172a;}
        .trx-desc{margin:6px 0 0;font-size:13px;color:#64748b;}
        .card{background:#fff;border-radius:24px;border:1px solid #e2e8f0;padding:16px;box-shadow:0 1px 3px rgba(15,23,42,.08);}
        .table-wrap{overflow:auto;border-radius:18px;border:1px solid #e2e8f0;}
        table{width:100%;border-collapse:separate;border-spacing:0;min-width:920px;}
        th,td{padding:12px 14px;text-align:left;white-space:nowrap;vertical-align:top;}
        th{font-size:11px;text-transform:uppercase;letter-spacing:.16em;color:#94a3b8;background:#f8fafc;font-weight:800;border-bottom:1px solid #e2e8f0;}
        td{font-size:13px;color:#0f172a;border-bottom:1px solid #f1f5f9;}
        tr:last-child td{border-bottom:0;}
        .pill{display:inline-flex;align-items:center;gap:8px;padding:6px 10px;border-radius:999px;font-size:12px;font-weight:800;border:1px solid transparent;}
        .pill--paid{background:rgba(34,197,94,.10);color:#166534;border-color:rgba(34,197,94,.20);}
        .pill--pending{background:rgba(245,158,11,.12);color:#92400e;border-color:rgba(245,158,11,.22);}
        .pill--failed{background:rgba(239,68,68,.10);color:#991b1b;border-color:rgba(239,68,68,.20);}
        .muted{color:#64748b;font-size:12px;}
        .money{font-weight:900;}
        .btn-proof{height:34px;padding:0 12px;border-radius:999px;border:1px solid #e2e8f0;background:#fff;font-weight:800;font-size:12px;color:#0f172a;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;transition:.15s ease;}
        .btn-proof:hover{background:#f8fafc;}
        .empty{padding:18px;text-align:center;color:#64748b;font-size:13px;}
        @media (max-width:767px){.trx-page{margin-top:-1rem;padding:1rem;}}
    </style>

    <div class="trx-page">
        <div class="trx-container">

            <div class="trx-head">
                <div>
                    <h1 class="trx-title">History Transaksi</h1>
                    <p class="trx-desc">Daftar transaksi subscription yang pernah kamu lakukan.</p>

                    {{-- Debug ringan: harusnya tampil 1 kalau memang ada --}}
                    <p class="muted" style="margin:8px 0 0;">
                        Total data terbaca: {{ $transactionsCount ?? 0 }}
                    </p>
                </div>
            </div>

            @if(! $user)
                <div class="card">
                    <p style="margin:0;color:#b91c1c;font-weight:800;">Kamu belum login.</p>
                </div>
            @else
                <div class="card">
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Kursus</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Mulai</th>
                                    <th>Dibuat</th>
                                    <th>Bukti</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($transactions as $t)
                                    <tr>
                                        <td>#{{ $t['id'] }}</td>

                                        <td>
                                            <div style="font-weight:900;">{{ $t['course_name'] }}</div>
                                            <div class="muted">{{ $user->email }}</div>
                                        </td>

                                        <td>
                                            <span class="pill {{ $t['status_class'] }}">
                                                {{ $t['status_label'] }}
                                                @if(($t['is_paid'] ?? false) === true)
                                                    ✓
                                                @endif
                                            </span>
                                        </td>

                                        <td class="money">{{ $t['amount_formatted'] }}</td>
                                        <td>{{ $t['subscription_start_date'] ?? '-' }}</td>
                                        <td>{{ $t['created_at'] ?? '-' }}</td>

                                        <td>
                                            @if(!empty($t['proof_url']))
                                                <a class="btn-proof" href="{{ $t['proof_url'] }}" target="_blank" rel="noopener">
                                                    Lihat
                                                </a>
                                            @else
                                                <span class="muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            <div class="empty">Belum ada transaksi.</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-filament-panels::page>
