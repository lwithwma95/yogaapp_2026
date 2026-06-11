<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View All Registrations</title>
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
                        <h1 class="m-0">Registration Summary</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('block.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">View Registrations</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">

                {{-- SUMMARY STAT BOXES --}}
                <div class="row">
                    <div class="col-6 col-md">
                        <div class="info-box shadow-sm">
                            <span class="info-box-icon bg-primary"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Members</span>
                                <span class="info-box-number">{{ number_format($total) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md">
                        <div class="info-box shadow-sm">
                            <span class="info-box-icon bg-success"><i class="fas fa-check-circle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Registered</span>
                                <span class="info-box-number">{{ number_format($registered) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md">
                        <div class="info-box shadow-sm">
                            <span class="info-box-icon bg-danger"><i class="fas fa-times-circle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Not Registered</span>
                                <span class="info-box-number">{{ number_format($notReg) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md">
                        <div class="info-box shadow-sm">
                            <span class="info-box-icon bg-info"><i class="fas fa-running"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Attendance</span>
                                <span class="info-box-number">{{ number_format($attendance) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md">
                        <div class="info-box shadow-sm">
                            <span class="info-box-icon bg-warning"><i class="fas fa-percent"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">% Registered</span>
                                <span class="info-box-number">{{ $percent }}%</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BLOCK CARD --}}
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-map-marked-alt mr-2"></i>Block Overview</h3>
                        <a href="{{ route('block.registrationsbyshg') }}" class="btn btn-sm btn-info float-right">
                            <i class="fas fa-filter"></i>
                            Filter
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="bg-primary text-white text-center">
                                <tr>
                                    <th>Block Name</th>
                                    <th width="13%">Total Members</th>
                                    <th width="13%">Registered</th>
                                    <th width="13%">Not Registered</th>
                                    <th width="13%">Attendance</th>
                                    <th width="16%">% Registered</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td class="text-left font-weight-bold">
                                        <a href="{{ route('block.registrations.gps') }}" class="text-primary">
                                            <i class="fas fa-arrow-right mr-1"></i>
                                            {{ $block->block_name ?? 'N/A' }}
                                        </a>
                                    </td>
                                    <td><span class="badge badge-primary px-2 py-1">{{ number_format($total) }}</span></td>
                                    <td><span class="badge badge-success px-2 py-1">{{ number_format($registered) }}</span></td>
                                    <td><span class="badge badge-danger px-2 py-1">{{ number_format($notReg) }}</span></td>
                                    <td><span class="badge badge-info px-2 py-1">{{ number_format($attendance) }}</span></td>
                                    <td>
                                        <div class="progress mb-1" style="height:8px">
                                            <div class="progress-bar bg-success" style="width:{{ $percent }}%"></div>
                                        </div>
                                        <small class="font-weight-bold">{{ $percent }}%</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </section>
    </div>

    @include('block.includes.footer')
</div>
</body>
</html>
