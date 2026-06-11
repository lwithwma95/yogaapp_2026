@include('yogaday2026.layouts.header')
<br>
<br>
<br>
{{-- ── STATS RIBBON ──────────────────────────────────────────── --}}
<div style="background:linear-gradient(90deg,#1b5e20,#2e7d32,#388e3c);padding:18px 0;">
    <div class="container">
        <div class="row text-center text-white g-2">
            <div class="col-6 col-md-3">
                <div style="font-size:1.9rem;font-weight:800;line-height:1;">
                    {{ number_format($totalRegistered) }}
                </div>
                <div style="font-size:11px;opacity:.85;text-transform:uppercase;letter-spacing:.5px;margin-top:3px;">
                    Registrations
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div style="font-size:1.9rem;font-weight:800;line-height:1;">
                    {{ number_format($totalMembers) }}
                </div>
                <div style="font-size:11px;opacity:.85;text-transform:uppercase;letter-spacing:.5px;margin-top:3px;">
                    Total Members
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div style="font-size:1.9rem;font-weight:800;line-height:1;">
                    {{ $districtStats->count() }}
                </div>
                <div style="font-size:11px;opacity:.85;text-transform:uppercase;letter-spacing:.5px;margin-top:3px;">
                    Districts
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div style="font-size:1.9rem;font-weight:800;line-height:1;">
                    @php
                        $pct = $totalMembers > 0 ? round(($totalRegistered / $totalMembers) * 100, 1) : 0;
                    @endphp
                    {{ $pct }}%
                </div>
                <div style="font-size:11px;opacity:.85;text-transform:uppercase;letter-spacing:.5px;margin-top:3px;">
                    Completion
                </div>
            </div>
        </div>
    </div>
</div>



{{-- ── ANALYTICS SECTION ────────────────────────────────────── --}}
@php
    $maxRegistered = $districtStats->max('registered') ?: 1;
    $chartHeight = max(520, $districtStats->count() * 26 + 80);
@endphp

<section style="background:linear-gradient(135deg,#f1f8e9 0%,#e8f5e9 60%,#e0f2f1 100%);padding:60px 0 70px;">
    <div class="container-fluid px-3 px-md-5">

        {{-- SECTION HEADER --}}
        <div class="text-center mb-5">

            <h2 style="font-size:2rem;font-weight:800;color:#1b5e20;margin-bottom:8px;">
                District-wise Registration Analytics
            </h2>
            <p style="color:#4f6b52;font-size:15px;max-width:520px;margin:0 auto;">
                IYD 2026 registration data across all districts of Assam
            </p>
        </div>

        <div class="row g-4 align-items-start">

            {{-- ── LEFT: SCROLLABLE TABLE ── --}}
            <div class="col-lg-4">
                <div
                    style="background:#fff;border-radius:16px;box-shadow:0 4px 24px rgba(46,125,50,.10);overflow:hidden;">

                    {{-- Table header with grand total --}}
                    {{-- Table header with grand total --}}
                    <div style="background:linear-gradient(135deg,#1b5e20,#2e7d32);padding:20px 22px;">

                        <div
                            style="font-size:11px;color:#a5d6a7;font-weight:700;text-transform:uppercase;letter-spacing:.7px;">
                            Total Registered Participants
                        </div>

                        <div style="font-size:2.6rem;font-weight:900;color:#fff;line-height:1.1;margin-top:4px;">
                            {{ number_format($totalRegistered) }}
                        </div>

                        

                        {{-- Progress Bar --}}
                        <div style="background:rgba(255,255,255,.2);border-radius:4px;height:6px;margin-top:10px;">
                            <div style="background:#a5d6a7;height:6px;border-radius:4px;width:{{ $pct }}%;"></div>
                        </div>

                        {{-- Extra Stats --}}
                        <div class="row mt-3 g-2">

                            <div class="col-6">
                                <div style="background:rgba(255,255,255,.12);padding:8px;border-radius:8px;">
                                    <div style="font-size:10px;color:#c8e6c9;text-transform:uppercase;">
                                        Remaining
                                    </div>
                                    <div style="font-size:16px;font-weight:800;color:#fff;">
                                        {{ number_format($totalMembers - $totalRegistered) }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div style="background:rgba(255,255,255,.12);padding:8px;border-radius:8px;">
                                    <div style="font-size:10px;color:#c8e6c9;text-transform:uppercase;">
                                        Districts
                                    </div>
                                    <div style="font-size:16px;font-weight:800;color:#fff;">
                                        {{ $districtStats->count() }}
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    {{-- Scrollable district list --}}
                    <div style="max-height:490px;overflow-y:auto;" id="districtTableScroll">
                        <table style="width:100%;border-collapse:collapse;font-size:13px;">

                            <thead>
                                <tr style="background:#f1f8e9;position:sticky;top:0;z-index:1;">
                                    <th style="padding:9px 10px;width:35px;">#</th>

                                    <th style="padding:9px 10px;">
                                        District
                                    </th>

                                    <th style="padding:9px 10px;text-align:right;">
                                        Total Members
                                    </th>

                                    <th style="padding:9px 10px;text-align:right;">
                                        Registered
                                    </th>

                                    <th style="padding:9px 10px;text-align:right;">
                                        %
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($districtStats as $row)

                                    @php
                                        $districtPct = $row->total > 0
                                            ? round(($row->registered / $row->total) * 100, 2)
                                            : 0;

                                        $barPct = $maxRegistered > 0
                                            ? round(($row->registered / $maxRegistered) * 100)
                                            : 0;

                                        $pctColor = $districtPct >= 75
                                            ? '#2e7d32'
                                            : ($districtPct >= 50
                                                ? '#ef6c00'
                                                : '#c62828');
                                    @endphp

                                    <tr style="
                                                    border-bottom:1px solid #f0f0f0;
                                                    @if($loop->iteration <= 3)
                                                        background:#fff8e1;
                                                    @elseif($loop->even)
                                                        background:#fafffe;
                                                    @endif
                                                ">

                                        {{-- Rank --}}
                                        <td style="padding:8px 10px;color:#888;font-weight:700;text-align:center;">
                                            {{ $loop->iteration }}
                                        </td>

                                        {{-- District --}}
                                        <td style="padding:8px 10px;">
                                            <div style="font-weight:600;color:#1a2e1c;">
                                                {{ $row->district_name }}
                                            </div>

                                            <div style="background:#e8f5e9;border-radius:3px;height:4px;margin-top:4px;">
                                                <div style="
                                                                background:#2e7d32;
                                                                height:4px;
                                                                border-radius:3px;
                                                                width:{{ $barPct }}%;
                                                            ">
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Total Members --}}
                                        <td style="padding:8px 10px;text-align:right;font-weight:600;color:#455a64;">
                                            {{ number_format($row->total) }}
                                        </td>

                                        {{-- Registered --}}
                                        <td style="padding:8px 10px;text-align:right;font-weight:700;color:#2e7d32;">
                                            {{ number_format($row->registered) }}
                                        </td>

                                        {{-- Percentage --}}
                                        <td
                                            style="padding:8px 10px;text-align:right;font-weight:800;color:{{ $pctColor }};">
                                            {{ number_format($districtPct, 2) }}%
                                        </td>

                                    </tr>

                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr style="background:#e8f5e9;border-top:2px solid #c8e6c9;">

                                    <td colspan="2" style="padding:10px 14px;font-weight:800;color:#1b5e20;">
                                        Grand Total
                                    </td>

                                    <td style="padding:10px;text-align:right;font-weight:900;color:#1b5e20;">
                                        {{ number_format($totalMembers) }}
                                    </td>

                                    <td style="padding:10px;text-align:right;font-weight:900;color:#1b5e20;">
                                        {{ number_format($totalRegistered) }}
                                    </td>

                                    <td style="padding:10px;text-align:right;font-weight:900;color:#1565c0;">
                                        {{ $pct }}%
                                    </td>

                                </tr>
                            </tfoot>

                        </table>
                    </div>

                </div>
            </div>

            {{-- ── RIGHT: HORIZONTAL CHART ── --}}
            <div class="col-lg-8">
                <div
                    style="background:#fff;border-radius:16px;box-shadow:0 4px 24px rgba(46,125,50,.10);overflow:hidden;">

                    <div
                        style="background:linear-gradient(90deg,#1b5e20,#388e3c);padding:16px 22px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
                        <div>
                            <div style="font-size:15px;font-weight:700;color:#fff;">
                                District-wise Yoga Participation
                            </div>
                            <div style="font-size:12px;color:#c8e6c9;margin-top:2px;">
                                IYD 2026 — Assam &bull; Sorted by highest registration percentage
                                @if($lastSynced)
                                    &bull; Updated {{ \Carbon\Carbon::parse($lastSynced)->format('d M Y') }}
                                @endif
                            </div>
                        </div>
                        <span
                            style="background:rgba(255,255,255,.15);color:#fff;font-size:11px;font-weight:700;padding:4px 14px;border-radius:50px;letter-spacing:.5px;text-transform:uppercase;">
                            {{ $districtStats->count() }} Districts
                        </span>
                    </div>

                    <div style="padding:16px 20px 20px;overflow-x:auto;max-height:520px;overflow-y:auto;">
                        <div style="min-height:{{ $chartHeight }}px;position:relative;">
                            <canvas id="districtChart"></canvas>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>


@include('yogaday2026.layouts.footer')

{{-- ── CHART.JS INITIALIZATION ─────────────────────────────── --}}
@php
    $chartLabels = $districtStats->pluck('district_name')->toArray();
    $chartData = $districtStats->pluck('registered')->toArray();
@endphp

<script>
    (function () {
        const labels = @json($chartLabels);
        const data = @json($chartData);

        const maxVal = Math.max(...data, 1);

        // Generate gradient shades of green — highest count darkest
        const bgColors = data.map(v => {
            const intensity = Math.round(55 + (v / maxVal) * 145);
            return `rgba(46, 125, 50, ${0.35 + (v / maxVal) * 0.65})`;
        });

        const ctx = document.getElementById('districtChart');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Registered Participants',
                    data: data,
                    backgroundColor: bgColors,
                    borderColor: bgColors.map(c => c.replace(/[\d.]+\)$/, '1)')),
                    borderWidth: 1,
                    borderRadius: 4,
                    borderSkipped: false,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                layout: { padding: { right: 10 } },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.04)' },
                        ticks: {
                            font: { size: 11 },
                            color: '#6c757d',
                            callback: v => v.toLocaleString()
                        }
                    },
                    y: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 12, weight: '600' },
                            color: '#1a2e1c',
                        }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => ' ' + ctx.parsed.x.toLocaleString() + ' registered'
                        }
                    }
                }
            }
        });

        // Resize canvas height to match district count
        ctx.parentElement.style.height = Math.max(520, labels.length * 26 + 80) + 'px';
    })();
</script>