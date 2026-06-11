<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1">

    <title>
        View Mapped SHGs
    </title>

    @include('block.includes.header')

</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

    <div class="wrapper">

        @include('block.includes.navbar')

        @include('block.includes.sidebar')

        {{-- CONTENT WRAPPER --}}

        <div class="content-wrapper">

            {{-- PAGE HEADER --}}

            <div class="content-header">

                <div class="container-fluid">

                    <div class="row mb-2">

                        <div class="col-sm-6">

                            <h1 class="m-0">

                                View Mapped SHGs

                            </h1>

                        </div>

                        <div class="col-sm-6">

                            <ol class="breadcrumb float-sm-right">

                                <li class="breadcrumb-item">

                                    <a href="{{ route('block.dashboard') }}">
                                        Home
                                    </a>

                                </li>

                                <li class="breadcrumb-item active">

                                    View Mapped SHGs

                                </li>

                            </ol>

                        </div>

                    </div>

                </div>

            </div>

            {{-- MAIN CONTENT --}}

            <section class="content">

                <div class="container-fluid">

                    {{-- ALERTS --}}

                    @if(session('success'))

                        <div class="alert alert-success alert-dismissible fade show">

                            <button type="button"
                                class="close"
                                data-dismiss="alert">

                                &times;

                            </button>

                            {{ session('success') }}

                        </div>

                    @endif

                    @if(session('error'))

                        <div class="alert alert-danger alert-dismissible fade show">

                            <button type="button"
                                class="close"
                                data-dismiss="alert">

                                &times;

                            </button>

                            {{ session('error') }}

                        </div>

                    @endif

                    {{-- VILLAGE INFO CARD --}}

                    <div class="card card-primary card-outline shadow-sm">

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-4">

                                    <strong>
                                        GP / VCDC
                                    </strong>

                                    <br>

                                    {{ $village->gp->gp_name ?? 'N/A' }}

                                </div>

                                <div class="col-md-4">

                                    <strong>
                                        Village
                                    </strong>

                                    <br>

                                    {{ $village->vill_name }}

                                </div>

                                <div class="col-md-4">

                                    <strong>
                                        Total SHGs
                                    </strong>

                                    <br>

                                    <span class="badge badge-primary p-2">

                                        {{ $shgs->count() }}

                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- SHG TABLE --}}

                    <div class="card card-success card-outline shadow-sm">

                        <div class="card-header">

                            <h3 class="card-title">

                                SHG List Under Village

                            </h3>

                        </div>

                        <div class="card-body table-responsive">

                            <table id="cadreTable"
                                class="table table-bordered table-hover table-sm table-striped">

                                <thead class="bg-success">

                                    <tr>

                                        <th width="10%">
                                            Sl No
                                        </th>

                                        <th>
                                            SHG Name
                                        </th>


                                        <th>
                                            Total Members
                                        </th>

                                        <th>
                                            Registered
                                        </th>

                                        <th>
                                            Unregistered
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($shgs as $shg)

                                        <tr>

                                            <td>

                                                {{ $loop->iteration }}

                                            </td>

                                            <td>

                                                {{ $shg->shg_name }} ({{ $shg->shg_code }})

                                            </td>

                                            

                                            <td>

                                                <span class="badge badge-info p-2">

                                                    {{ $shg->total_members }}

                                                </span>

                                            </td>

                                            <td>

                                                <span class="badge badge-success p-2">

                                                    {{ $shg->registered_members }}

                                                </span>

                                            </td>

                                            <td>

                                                <span class="badge badge-danger p-2">

                                                    {{ $shg->total_members - $shg->registered_members }}

                                                </span>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </section>

        </div>

        @include('block.includes.footer')

    </div>

    <script>

        $(document).ready(function () {

            $('#cadreTable').DataTable({

                responsive: true,

                lengthMenu: [

                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]

                ],

                pageLength: 10,

                dom: 'Bfrtip',

                buttons: [

                    {

                        extend: 'excelHtml5',

                        title: 'Mapped_SHGs_Report',

                        text: '<i class="fas fa-file-excel"></i> Export Excel',

                        className: 'btn btn-success btn-sm'

                    },

                    {

                        extend: 'print',

                        text: '<i class="fas fa-print"></i> Print',

                        className: 'btn btn-primary btn-sm'

                    }

                ]

            });

        });

    </script>

</body>

</html>