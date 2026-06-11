<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Village-wise Registrations</title>
    @include('block.includes.header')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        @include('block.includes.navbar')
        @include('block.includes.sidebar')

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Village-wise Registrations</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('block.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('block.viewallregistrations') }}">Registrations</a></li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('block.registrations.gps') }}">{{ $block->block_name ?? '' }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ $gp->gp_name ?? '' }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">

                    {{-- VILLAGE TABLE --}}
                    <div class="card card-primary card-outline shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                {{ $gp->gp_name ?? '' }} — Village-wise Details
                            </h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table id="villageTable"
                                class="table table-bordered table-hover table-sm align-middle mb-0">
                                <thead class="bg-primary text-white text-center">
                                    <tr>
                                        <th width="6%">Sl No</th>
                                        <th>Village Name</th>
                                        <th width="13%">Total Members</th>
                                        <th width="13%">Registered</th>
                                        <th width="13%">Not Registered</th>
                                        <th width="13%">Attendance</th>
                                        <th width="16%">% Registered</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($villagerows as $row)
                                        @php
                                            $notR = $row->total - $row->registered;
                                            $pct = $row->total > 0 ? round(($row->registered / $row->total) * 100, 1) : 0;
                                        @endphp
                                        <tr class="text-center">
                                            <td class="sl-no"></td>
                                            <td class="text-left font-weight-bold">
                                                <a href="{{ route('block.registrations.shgs', $row->vill_id) }}"
                                                    class="text-primary">
                                                    <i class="fas fa-arrow-right mr-1"></i>{{ $row->vill_name }}
                                                </a>
                                            </td>
                                            <td><span
                                                    class="badge badge-primary px-2 py-1">{{ number_format($row->total) }}</span>
                                            </td>
                                            <td><span
                                                    class="badge badge-success px-2 py-1">{{ number_format($row->registered) }}</span>
                                            </td>
                                            <td><span class="badge badge-danger px-2 py-1">{{ number_format($notR) }}</span>
                                            </td>
                                            <td><span
                                                    class="badge badge-info px-2 py-1">{{ number_format($row->attendance) }}</span>
                                            </td>
                                            <td>
                                                <div class="progress mb-1" style="height:8px">
                                                    <div class="progress-bar bg-success" style="width:{{ $pct }}%"></div>
                                                </div>
                                                <small class="font-weight-bold">{{ $pct }}%</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-light font-weight-bold">
                                    @php
                                        $footerTotal = $villagerows->sum('total');
                                        $footerRegistered = $villagerows->sum('registered');
                                        $footerNotReg = $footerTotal - $footerRegistered;
                                        $footerAttendance = $villagerows->sum('attendance');
                                        $footerPct = $footerTotal > 0
                                            ? round(($footerRegistered / $footerTotal) * 100, 1)
                                            : 0;
                                    @endphp

                                    <tr class="text-center">
                                        <td colspan="2" class="text-right">
                                            <strong>Grand Total</strong>
                                        </td>

                                        <td class="text-center">
                                           
                                                {{ number_format($footerTotal) }}
                                            
                                        </td>

                                        <td class="text-center">
                                          
                                                {{ number_format($footerRegistered) }}
                                      
                                        </td>

                                        <td class="text-center">
                                       
                                                {{ number_format($footerNotReg) }}
                                 
                                        </td>

                                        <td class="text-center">
                                           
                                                {{ number_format($footerAttendance) }}
                                          
                                        </td>

                                        <td class="text-center">
                                            <strong>{{ $footerPct }}%</strong>
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
            $('#villageTable').DataTable({
                responsive: true,
                pageLength: 25,
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-success btn-sm', title: 'Village_wise_Registrations' },
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