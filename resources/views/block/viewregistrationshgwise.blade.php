<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SHG-wise Registrations</title>
    @include('block.includes.header')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        @include('block.includes.navbar')
        @include('block.includes.sidebar')
        <br>
        <div class="content-wrapper">


            <section class="content">
                <div class="container-fluid">

                    {{-- SHG TABLE --}}
                    <div class="card card-primary card-outline shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-sitemap mr-2"></i>
                                {{ $village->vill_name ?? '' }} — SHG-wise Details
                            </h3>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table id="shgTable" class="table table-bordered table-hover table-sm align-middle mb-0">
                                <thead class="bg-primary text-white text-center">
                                    <tr>
                                        <th width="6%">Sl No</th>
                                        <th>SHG Name (Code)</th>
                                        <th width="13%">Total Members</th>
                                        <th width="13%">Registered</th>
                                        <th width="13%">Not Registered</th>
                                        <th width="13%">Attendance</th>
                                        <th width="16%">% Registered</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($rows as $row)
                                        @php
                                            $notR = $row->total - $row->registered;
                                            $pct = $row->total > 0
                                                ? round(($row->registered / $row->total) * 100, 1)
                                                : 0;
                                        @endphp

                                        <tr class="text-center">
                                            <td class="sl-no"></td>

                                            <td class="text-left">
                                                <div class="font-weight-bold text-primary">
                                                    <a href="{{ route('block.shg.registered', $row->shg_code) }}">{{ $row->shg_name }} ({{ $row->shg_code }})</a>
                                                </div>
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
                                                    {{ number_format($notR) }}
                                                </span>
                                            </td>

                                            <td>
                                                <span class="badge badge-info px-2 py-1">
                                                    {{ number_format($row->attendance) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="progress mb-1" style="height:8px">
                                                    <div class="progress-bar bg-success" style="width:{{ $pct }}%">
                                                    </div>
                                                </div>

                                                <small class="font-weight-bold">
                                                    {{ $pct }}%
                                                </small>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">
                                                No SHGs found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>

                                <tfoot class="bg-light font-weight-bold">
                                    <tr class="text-center">
                                        <td colspan="2" class="text-right">
                                            Grand Total
                                        </td>

                                        <td class="text-center">

                                            {{ number_format($total) }}

                                        </td>

                                        <td class="text-center">

                                            {{ number_format($registered) }}

                                        </td>

                                        <td class="text-center">

                                            {{ number_format($notReg) }}

                                        </td>

                                        <td class="text-center">

                                            {{ number_format($totalAttendance) }}

                                        </td>

                                        <td class="text-center">
                                            {{ $percent }}%
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
            </section>
        </div>

        @include('block.includes.footer')
    </div>

    <script>
        $(function () {
            $('#shgTable').DataTable({
                responsive: true,
                pageLength: 25,
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-success btn-sm', title: 'SHG_wise_Registrations' },
                    { extend: 'print', text: '<i class="fas fa-print"></i> Print', className: 'btn btn-primary btn-sm' }
                ],
                columnDefs: [{ orderable: false, targets: 0 }],
                order: [[6, 'asc']],
                drawCallback: function (settings) {
                    var api = this.api();
                    var start = api.page.info().start;
                    api.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                        cell.innerHTML = start + i + 1;
                    });
                }
            });
        });
    </script>
</body>

</html>