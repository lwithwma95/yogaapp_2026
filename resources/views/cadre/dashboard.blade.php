<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadre Dashboard</title>
    @include('cadre.includes.header')
    <style>
        .cd-stat-card {
            border: none; border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,.07);
            transition: transform .15s, box-shadow .15s;
        }
        .cd-stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.11); }
        .cd-stat-icon {
            width: 50px; height: 50px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 21px; flex-shrink: 0;
        }
        .cd-stat-value { font-size: 1.9rem; font-weight: 800; line-height: 1; }
        .cd-stat-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #6c757d; margin-top: 3px; }

        .venue-banner { border: none; border-radius: 14px; overflow: hidden; box-shadow: 0 2px 16px rgba(0,0,0,.08); }
        .venue-banner .card-header {
            background: linear-gradient(135deg, #1a3c2e 0%, #14532d 60%, #1a6b3c 100%);
            color: #fff; padding: 18px 22px;
        }

        .chart-card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.07); }
        .chart-card .card-header {
            background: #f8f9fa; border-bottom: 2px solid #dee2e6;
            border-radius: 12px 12px 0 0; padding: 10px 16px;
        }
        .chart-card .card-header h6 { margin: 0; font-weight: 700; font-size: 13px; }

        .quick-link-card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.07); }
        .quick-link-btn { border-radius: 50px; font-weight: 600; }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

    @include('cadre.includes.navbar')
    @include('cadre.includes.sidebar')

    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Cadre Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">

                {{-- Venue Banner --}}
                @if($venue)
                <div class="card venue-banner mb-3">
                    <div class="card-header d-flex align-items-center justify-content-between flex-wrap" style="gap:10px;">
                        <div>
                            <div style="font-size:11px;opacity:.75;text-transform:uppercase;letter-spacing:.5px;">Your Assigned Venue</div>
                            <h4 class="mb-0 mt-1" style="font-weight:800;">
                                <i class="fas fa-map-marker-alt mr-2"></i>{{ $venue->venue_name }}
                            </h4>
                        </div>
                        <div class="d-flex flex-wrap" style="gap:8px;">
                            <span class="badge badge-light text-dark px-3 py-2">
                                <i class="fas fa-user mr-1"></i>{{ $memberName ?? 'N/A' }}
                            </span>
                            <span class="badge badge-light text-dark px-3 py-2">
                                <i class="fas fa-users mr-1"></i>Capacity: {{ $venue->capacity }}
                            </span>
                        </div>
                    </div>
                </div>
                @else
                <div class="alert alert-warning alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    No venue has been assigned to your account yet. Please contact your Block Admin.
                </div>
                @endif

                {{-- Stat Cards --}}
                <div class="row mb-3">
                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="card cd-stat-card">
                            <div class="card-body d-flex align-items-center" style="gap:14px;padding:16px 18px">
                                <div class="cd-stat-icon" style="background:rgba(30,136,200,.12)">
                                    <i class="fas fa-layer-group" style="color:#1e88c8"></i>
                                </div>
                                <div>
                                    <div class="cd-stat-value" style="color:#1e88c8">{{ $totalShgs }}</div>
                                    <div class="cd-stat-label">Assigned SHGs</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="card cd-stat-card">
                            <div class="card-body d-flex align-items-center" style="gap:14px;padding:16px 18px">
                                <div class="cd-stat-icon" style="background:rgba(108,117,125,.12)">
                                    <i class="fas fa-users text-secondary"></i>
                                </div>
                                <div>
                                    <div class="cd-stat-value text-secondary">{{ $totalMembers }}</div>
                                    <div class="cd-stat-label">Total Members</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="card cd-stat-card">
                            <div class="card-body d-flex align-items-center" style="gap:14px;padding:16px 18px">
                                <div class="cd-stat-icon" style="background:rgba(40,167,69,.12)">
                                    <i class="fas fa-user-check text-success"></i>
                                </div>
                                <div>
                                    <div class="cd-stat-value text-success">{{ $registeredMembers }}</div>
                                    <div class="cd-stat-label">Registered</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="card cd-stat-card">
                            <div class="card-body d-flex align-items-center" style="gap:14px;padding:16px 18px">
                                <div class="cd-stat-icon" style="background:rgba(220,53,69,.12)">
                                    <i class="fas fa-user-times text-danger"></i>
                                </div>
                                <div>
                                    <div class="cd-stat-value text-danger">{{ $unregisteredMembers }}</div>
                                    <div class="cd-stat-label">Not Registered</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                

            </div>
        </section>
    </div>

    @include('cadre.includes.footer')

</div>

@if($totalMembers > 0)
<script>
$(document).ready(function () {

    // ── Doughnut: Registered vs Not Registered ─────────────────────
    new Chart(document.getElementById('regDonut'), {
        type: 'doughnut',
        data: {
            labels: ['Registered', 'Not Registered'],
            datasets: [{
                data: [{{ $registeredMembers }}, {{ $unregisteredMembers }}],
                backgroundColor: ['#28a745', '#dc3545'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            cutoutPercentage: 65,
            legend: { position: 'bottom' },
            tooltips: {
                callbacks: {
                    label: function (ti, data) {
                        const val   = data.datasets[0].data[ti.index];
                        const total = data.datasets[0].data.reduce(function (a, b) { return a + b; }, 0);
                        const pct   = total > 0 ? Math.round(val / total * 100) : 0;
                        return ' ' + data.labels[ti.index] + ': ' + val + ' (' + pct + '%)';
                    }
                }
            }
        }
    });

    // ── Stacked Bar: Registered vs Unregistered per SHG ───────────
    const shgLabels = @json($shgStats->pluck('name')->values());
    const shgReg    = @json($shgStats->pluck('registered')->values());
    const shgUnreg  = @json($shgStats->pluck('unregistered')->values());

    new Chart(document.getElementById('shgBar'), {
        type: 'bar',
        data: {
            labels: shgLabels,
            datasets: [
                {
                    label: 'Registered',
                    data: shgReg,
                    backgroundColor: 'rgba(40,167,69,0.75)',
                    borderColor: '#28a745',
                    borderWidth: 1
                },
                {
                    label: 'Not Registered',
                    data: shgUnreg,
                    backgroundColor: 'rgba(220,53,69,0.65)',
                    borderColor: '#dc3545',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                xAxes: [{ stacked: true, ticks: { fontSize: 10 } }],
                yAxes: [{ stacked: true, ticks: { beginAtZero: true, precision: 0 } }]
            },
            legend: { position: 'bottom' }
        }
    });

});
</script>
@endif

</body>
</html>
