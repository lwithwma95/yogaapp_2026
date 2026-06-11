<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registered Members – {{ $venue->venue_name ?? 'Venue' }}</title>
    @include('cadre.includes.header')
    <style>
        .cv-stat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .07);
            transition: transform .15s, box-shadow .15s;
        }

        .cv-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, .11);
        }

        .cv-stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
            flex-shrink: 0;
        }

        .cv-stat-value {
            font-size: 1.9rem;
            font-weight: 800;
            line-height: 1;
        }

        .cv-stat-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #6c757d;
            margin-top: 3px;
        }

        .venue-hdr {
            border: none;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 16px rgba(0, 0, 0, .08);
        }

        .venue-hdr .card-header {
            background: linear-gradient(135deg, #1a3c2e 0%, #14532d 60%, #1a6b3c 100%);
            color: #fff;
            padding: 18px 22px;
        }

        .shg-main-card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 2px 16px rgba(0, 0, 0, .08);
            overflow: hidden;
        }

        .shg-main-card>.card-header {
            background: linear-gradient(135deg, #1e3a5f 0%, #1565a0 60%, #1e88c8 100%);
            color: #fff;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
            border-bottom: none;
        }

        .shg-main-card>.card-header h5 {
            margin: 0;
            font-size: 15px;
            font-weight: 700;
        }

        .shg-main-card>.card-body {
            padding: 0;
        }

        .shg-tbl thead th {
            background: #f0f4f8;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .4px;
            color: #495057;
            border-bottom: 2px solid #dee2e6;
            white-space: nowrap;
            padding: 10px 12px;
        }

        .shg-tbl tbody td {
            vertical-align: middle;
            padding: 10px 12px;
            font-size: 13px;
        }

        .shg-tbl tbody tr:hover {
            background: #f5f8ff !important;
        }

        .shg-name-txt {
            font-weight: 700;
            font-size: 14px;
            color: #212529;
        }

        .shg-code-txt {
            font-size: 11px;
            color: #868e96;
            margin-top: 2px;
        }
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
                            <h1 class="m-0">View registered Members</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('cadre.dashboard') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">view Registered Members</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                        </div>
                    @endif

                    @php
                        $totalSHGs = $shgs->count();
                        $totalReg = $shgs->sum('registered_count');
                        $totalUnreg = $shgs->sum('members_count') - $totalReg;
                    @endphp

                    {{-- Venue Info --}}
                    <div class="card venue-hdr mb-3">
                        <div class="card-header d-flex align-items-center justify-content-between flex-wrap"
                            style="gap:8px;">
                            <div>
                                <div style="font-size:11px;opacity:.75;text-transform:uppercase;letter-spacing:.5px;">
                                    Assigned Venue</div>
                                <h3 class="mb-0 mt-1" style="font-weight:800;">
                                    <i class="fas fa-map-marker-alt mr-2"></i>{{ $venue->venue_name ?? 'N/A' }}
                                </h3>
                            </div>
                            <span class="badge badge-light text-dark px-3 py-2" style="font-size:12px;">
                                <i class="fas fa-user mr-1"></i>{{ $memberName }}
                            </span>
                        </div>
                    </div>

                    {{-- Summary Stats --}}
                    <div class="row mb-3">
                        <div class="col-md-4 col-sm-6 mb-3 mb-md-0">
                            <div class="card cv-stat-card">
                                <div class="card-body d-flex align-items-center" style="gap:14px;padding:16px 18px">
                                    <div class="cv-stat-icon" style="background:rgba(30,136,200,.12)">
                                        <i class="fas fa-layer-group" style="color:#1e88c8"></i>
                                    </div>
                                    <div>
                                        <div class="cv-stat-value" style="color:#1e88c8">{{ $totalSHGs }}</div>
                                        <div class="cv-stat-label">Add Attendance</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 mb-3 mb-md-0">
                            <div class="card cv-stat-card">
                                <div class="card-body d-flex align-items-center" style="gap:14px;padding:16px 18px">
                                    <div class="cv-stat-icon" style="background:rgba(40,167,69,.12)">
                                        <i class="fas fa-user-check text-success"></i>
                                    </div>
                                    <div>
                                        <div class="cv-stat-value text-success">{{ $totalReg }}</div>
                                        <div class="cv-stat-label">Registered Members</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 mb-3 mb-md-0">
                            <div class="card cv-stat-card">
                                <div class="card-body d-flex align-items-center" style="gap:14px;padding:16px 18px">
                                    <div class="cv-stat-icon" style="background:rgba(220,53,69,.12)">
                                        <i class="fas fa-user-times text-danger"></i>
                                    </div>
                                    <div>
                                        <div class="cv-stat-value text-danger">{{ $totalUnreg }}</div>
                                        <div class="cv-stat-label">Not Registered</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SHG Table --}}
                    <div class="card shg-main-card">
                        <div class="card-header">
                            <h5><i class="fas fa-sitemap mr-2"></i>SHG List assigned under {{ $venue->venue_name ?? '' }}</h5>
                            <span class="badge badge-light text-dark px-2 py-1" style="font-size:12px;">
                                {{ $totalSHGs }} SHG{{ $totalSHGs !== 1 ? 's' : '' }}
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="shgTable" class="table table-bordered table-hover shg-tbl mb-0">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center">#</th>
                                            <th>SHG Name</th>
                                            <th width="11%" class="text-center">Total</th>
                                            <th width="14%" class="text-center">Registered</th>
                                            <th width="16%" class="text-center">Not Registered</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($shgs as $i => $shg)
                                            @php
                                                $reg = $shg->registered_count ?? 0;
                                                $total = $shg->members_count ?? 0;
                                                $unreg = $total - $reg;
                                                
                                            @endphp
                                            <tr class="{{ $total > 0 && $reg === 0 ? 'table-warning' : '' }}">
                                                <td class="text-center text-muted">{{ $i + 1 }}</td>
                                                <td>
                                                    <a href="{{ route('cadre.viewregistered.members', $shg->shg_code) }}"><strong>{{ $shg->shg_name }}</strong>
                                                    <div class="shg-code-txt">{{ $shg->shg_code }}</div></a>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge badge-secondary px-2 py-1">{{ $total }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge {{ $reg > 0 ? 'badge-success' : 'badge-secondary' }} px-2 py-1">
                                                        {{ $reg }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge {{ $unreg > 0 ? 'badge-danger' : 'badge-secondary' }} px-2 py-1">
                                                        {{ $unreg }}
                                                    </span>
                                                </td>
                                                
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    <i class="fas fa-info-circle mr-1"></i>
                                                    No SHGs have been mapped to your venue yet.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>

        @include('cadre.includes.footer')

    </div>

    <script>
        $(document).ready(function () {

            const table = $('#shgTable');

            // Destroy if already initialized
            if ($.fn.DataTable.isDataTable(table)) {
                table.DataTable().destroy();
            }

            // IMPORTANT: check if real data exists (not empty row)
            const hasData = table.find('tbody tr').length > 0
                && !table.find('tbody tr td').attr('colspan');

            if (hasData) {

                table.DataTable({
                    responsive: true,
                    pageLength: 25,

                    dom: 'Bfrtip',

                    buttons: [
                        {
                            extend: 'excelHtml5',
                            title: 'Assigned_SHG_Report',
                            text: '<i class="fas fa-file-excel"></i> Export',
                            className: 'btn btn-success btn-sm'
                        },
                        {
                            extend: 'print',
                            text: '<i class="fas fa-print"></i> Print',
                            className: 'btn btn-primary btn-sm'
                        }
                    ],

                    columnDefs: [
                        { orderable: false, targets: 4 } // Action column
                    ]

                });

            }

        });
    </script>

</body>

</html>