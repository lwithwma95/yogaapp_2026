<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mapped Shgs </title>
    @include('district.includes.header')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        @include('district.includes.navbar')
        @include('district.includes.sidebar')

        <div class="content-wrapper">

            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Mapped Shgs</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('district.dashboard') }}">Home</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">

                    {{-- VENUES TABLE --}}
                    <div class="card shadow-sm" style="border:none;border-radius:12px;overflow:hidden;">
                        <div class="card-header"
                            style="background:linear-gradient(135deg,#1e3a5f,#1565a0,#1e88c8);color:#fff;padding:14px 20px;">
                            <h5 class="mb-0" style="font-size:15px;font-weight:700;">
                                <i class="fas fa-users mr-2"></i>
                                SHGs Mapped to Venue
                            </h5>

                            @if($venue)
                                <small class="d-block mt-1 text-center" style="font-size: x-large;">
                                    Venue: {{ $venue->venue_name }}
                                </small>
                                <small class="d-block mt-1 text-center" style="font-size: larger;">
                                    Capacity: {{ $venue->capacity }}
                                </small>
                                <small class="d-block mt-1 text-center" style="font-size: medium;">
                                    Cadre: {{ $venue->cadre_name }}
                                </small>
                            @endif
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table id="shgTable" class="table table-bordered table-hover mb-0"
                                    style="font-size:15px;">

                                    <thead class="text-center" style="background:#f0f4f8;">
                                        <tr>
                                            <th width="8%">#</th>
                                            <th>SHG Name (SHG Code)</th>
                                            <th width="15%">Total Members</th>
                                            <th>Total Registered Members</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                            $grandTotalMembers = 0;
                                            $grandTotalRegistered = 0;
                                        @endphp

                                        @forelse($shgs as $shg)
                                            @php
                                                $grandTotalMembers += $shg->total_members;
                                                $grandTotalRegistered += $shg->total_registered;
                                            @endphp

                                            <tr>
                                                <td class="text-center">
                                                    {{ $loop->iteration }}
                                                </td>

                                                <td>
                                                    <a href="{{ route('district.shg.registered', ['shg_code' => $shg->shg_code]) }}"
                                                        target="_blank" class="text-decoration-none font-weight-bold">
                                                        {{ $shg->shg_name }}
                                                    </a>
                                                    <br>
                                                    <small class="text-muted">
                                                        {{ $shg->shg_code }}
                                                    </small>
                                                </td>

                                                <td class="text-center">
                                                    <span class="badge badge-primary px-3 py-2" style="font-size:13px;">
                                                        {{ $shg->total_members }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge badge-success px-3 py-2" style="font-size:13px;">
                                                        {{ $shg->total_registered }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">
                                                    No SHGs mapped to this venue.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>

                                    @if($shgs->count())
                                        <tfoot style="background:#f8f9fa;font-weight:700;">
                                            <tr>
                                                <td colspan="1" class="text-center">
                                                    Total
                                                </td>

                                                <td>
                                                    {{ $shgs->count() }} SHGs
                                                </td>

                                                <td class="text-center">
                                                    {{ number_format($grandTotalMembers) }}
                                                </td>
                                                <td class="text-center">
                                                    {{ number_format($grandTotalRegistered) }}
                                                </td>
                                            </tr>
                                        </tfoot>
                                    @endif
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
            $('#venueTable').DataTable({
                responsive: true, pageLength: 25,
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-success btn-sm', title: 'Village_Mapped Shgs_CVM' },
                    { extend: 'print', text: '<i class="fas fa-print"></i> Print', className: 'btn btn-primary btn-sm' }
                ],
                order: [[1, 'asc']]
            });
        });
    </script>
</body>

</html>