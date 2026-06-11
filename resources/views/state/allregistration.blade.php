<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All {{ ucwords($r_type) }} Registration</title>
    @include('state.includes.header')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        @include('state.includes.navbar')
        @include('state.includes.sidebar')
<br>
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    {{-- DISTRICT TABLE --}}
                    <div class="card shadow-sm" style="border:none;border-radius:12px;overflow:hidden;">
                        <div class="card-header"
                            style="background:linear-gradient(135deg,#1e3a5f,#1565a0,#1e88c8);color:#fff;padding:14px 20px;">
                            <h5 class="mb-0" style="font-size:15px;font-weight:700;">
                                <i class="fas fa-map mr-2"></i>Common {{ $r_type }}-wise Registration &amp; Attendance
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                @php
                                    $total_member = $report->sum('total_member');
                                    $total_reg = $report->sum('total_reg');
                                    $total_pend = $total_member-$total_reg;
                                    $total_att = $report->sum('total_att');
                                @endphp

                                <table id="districtTable" class="table table-bordered table-hover mb-0"
                                    style="font-size:13px;">

                                    <thead class="text-center" style="background:#f0f4f8;">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th class="text-left">{{ ucwords($r_type) }} Name</th>
                                            <th width="9%">Total Member</th>
                                            <th width="9%">Total Registered</th>
                                            <th width="9%">Pending</th>
                                            <th  width="9%">Total Attendant</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($report as $row)
                                            <tr class="text-center">
                                                <td class="text-muted">{{ $loop->iteration }}</td>

                                                <td class="text-left font-weight-bold">
                                                    <a href="{{ route('state.' . $r_type . '.details', $row->id) }}" class="text-primary">
                                                        
                                                        <i class="fas fa-arrow-right mr-1" style="font-size:10px;"></i>
                                                        {{ $row->name }}
                                                    </a>
                                                </td>

                                                <td>
                                                    <span class="badge badge-secondary px-2 py-1">
                                                        {{ number_format($row->total_member) }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="badge badge-success px-2 py-1">
                                                        {{ number_format($row->total_reg) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-danger px-2 py-1">
                                                        {{ number_format($row->total_member-$row->total_reg) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-info px-2 py-1">
                                                        {{ number_format($row->total_att) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    No data found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>

                                    {{-- ✅ FOOTER --}}
                                    <tfoot style="background:#e9f2fb; font-weight:600;">
                                        <tr class="text-center">
                                            <td colspan="2" class="text-right">TOTAL</td>

                                            <td class="text-center">
                                                    {{ number_format($total_member) }}
                                            </td>

                                            <td class="text-center">
                                                    {{ number_format($total_reg) }}
                                            </td>
                                            <td class="text-center">
                                                    {{ number_format($total_pend) }}
                                            </td>
                                            <td class="text-center">
                                                    {{ number_format($total_att) }}
                                            </td>
                                        </tr>
                                    </tfoot>

                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>

        @include('state.includes.footer')
    </div>

    <script>
        $(function () {
            $('#districtTable').DataTable({
                responsive: true,
                pageLength: 35,
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-success btn-sm', title: 'State_District_Report' },
                    { extend: 'print', text: '<i class="fas fa-print"></i> Print', className: 'btn btn-primary btn-sm' }
                ],
                order: [[1, 'asc']]
            });
        });
    </script>
</body>

</html>