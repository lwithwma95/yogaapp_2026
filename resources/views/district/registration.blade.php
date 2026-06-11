<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>District Registration</title>
    @include('district.includes.header')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<br>    
<div class="wrapper">
        @include('district.includes.navbar')
        @include('district.includes.sidebar')
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    {{-- BLOCK-WISE TABLE --}}
                    <div class="card shadow-sm" style="border:none;border-radius:12px;overflow:hidden;">
                        <div class="card-header"
                            style="background:linear-gradient(135deg,#1e3a5f,#1565a0,#1e88c8);color:#fff;padding:14px 20px;">
                            <h5 class="mb-0" style="font-size:15px;font-weight:700;">
                                <i class="fas fa-th-list mr-2"></i>
                                Block-wise Registration &amp; Attendance Report
                            </h5>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table id="blockTable" class="table table-bordered table-hover mb-0"
                                    style="font-size:13px;">
                                    <thead class="text-center" style="background:#f0f4f8;">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th class="text-left">Block Name</th>
                                            <th width="11%">Total Members</th>
                                            <th width="11%">Registered</th>
                                            <th width="11%">Not Reg.</th>
                                            <th width="13%">% Reg.</th>
                                            <th width="11%">Attended</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($blocks as $row)
                                            @php
                                                $nr = $row->total - $row->registered;
                                                $pct = $row->total > 0
                                                    ? round(($row->registered / $row->total) * 100, 1)
                                                    : 0;
                                            @endphp

                                            <tr class="text-center">
                                                <td class="text-muted">
                                                    {{ $loop->iteration }}
                                                </td>

                                                <td class="text-left font-weight-bold">
                                                    <a href="{{ route('district.block.details', $row->block_id) }}"
                                                        class="text-primary">
                                                        <i class="fas fa-arrow-right mr-1" style="font-size:10px;"></i>
                                                        {{ $row->block_name }}
                                                    </a>
                                                </td>



                                                <td>
                                                    <span class="badge badge-primary px-2 py-1">
                                                        {{ number_format($row->total) }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="badge badge-success px-2 py-1">
                                                        {{ number_format($row->registered) }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="badge badge-danger px-2 py-1">
                                                        {{ number_format($nr) }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <div class="progress mb-1" style="height:7px;border-radius:4px;">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width:{{ $pct }}%;">
                                                        </div>
                                                    </div>
                                                    <small class="font-weight-bold">
                                                        {{ $pct }}%
                                                    </small>
                                                </td>

                                                <td>
                                                    <span class="badge badge-warning px-2 py-1">
                                                        {{ number_format($row->attendance) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-muted py-4">
                                                    No block data found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>

                                    <tfoot class="text-center font-weight-bold" style="background:#f8f9fa;">
                                        @php
                                            $totalShg = $blocks->sum('total_shg');
                                            $totalMembers = $blocks->sum('total');
                                            $totalRegistered = $blocks->sum('registered');
                                            $totalAttendance = $blocks->sum('attendance');
                                            $totalNotReg = $totalMembers - $totalRegistered;
                                            $percent = $totalMembers > 0
                                                ? round(($totalRegistered / $totalMembers) * 100, 1)
                                                : 0;
                                        @endphp

                                        <tr>
                                            <td colspan="2" class="text-right">Total</td>

                                            <td  class="text-center">{{ number_format($totalMembers) }}</td>
                                            <td class="text-center">{{ number_format($totalRegistered) }}</td>
                                            <td class="text-center">{{ number_format($totalNotReg) }}</td>
                                            <td class="text-center">{{ $percent }}%</td>
                                            <td class="text-center">{{ number_format($totalAttendance) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>

        @include('district.includes.footer')
    </div>

    <script>
        $(function () {
            $('#blockTable').DataTable({
                responsive: true,
                pageLength: 25,
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-success btn-sm', title: 'District_Block_Report' },
                    { extend: 'print', text: '<i class="fas fa-print"></i> Print', className: 'btn btn-primary btn-sm' }
                ],
                order: [[1, 'asc']]
            });
        });
    </script>
</body>

</html>