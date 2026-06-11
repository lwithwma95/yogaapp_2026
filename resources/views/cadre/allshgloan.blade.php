<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All SHG Loans Assigned</title>

    @include('cadre.includes.header')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        @include('cadre.includes.navbar')

        @include('cadre.includes.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">All My SHG Loans Assigned</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('cadre.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">All SHG</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">
                                &times;
                            </button>

                            <i class="fas fa-check-circle"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">
                                &times;
                            </button>

                            <i class="fas fa-times-circle"></i>
                            {{ session('error') }}
                        </div>
                    @endif


                    <!-- SHG Data Table -->
                    <div class="card">

                        <div class="card-header">

                            <h3 class="card-title">
                                SHG Loan List
                            </h3>

                            <div class="card-tools">

                                <a href="{{ route('cadre.shgloan.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Add Loan
                                </a>

                            </div>

                        </div>

                        <div class="card-body">

                            <table id="shgTable" class="table table-bordered table-striped table-sm">

                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>SHG Name</th>
                                        <th>SHG Code</th>
                                        <th>Village</th>
                                        <th>Loan Amount</th>
                                        <th>Already Paid</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach($loans as $loan)

                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>{{ $loan->shg->name }}</td>
                                                                        <td>{{ $loan->shg->shg_code }}</td>
                                                                        <td>{{ $loan->shg->village }}</td>
                                                                        <td>{{ $loan->loan_amount }}</td>
                                                                        <td>{{ $loan->already_paid }}</td>
                                                                        <td>{{ \Carbon\Carbon::create()->day($loan->due_date)->format('jS') }} of every month</td>
                                                                        <td>
                                                                            @if($loan->status == 'Running')
                                                                                <span class="badge badge-warning">
                                                                                    {{ ucfirst($loan->status) }}
                                                                                </span>
                                                                            @else
                                                                                <span class="badge badge-success">
                                                                                    {{ ucfirst($loan->status) }}
                                                                                </span>
                                                                            @endif
                                                                        </td>
                                                                        <td>

                                                                            <a href="{{ route('cadre.shgloan.view', $loan->id) }}"
                                                                                class="btn btn-info btn-sm">
                                                                                <i class="fas fa-eye"></i>
                                                                            </a>

                                                                        </td>
                                                                    </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>
            </section>

            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        @include('cadre.includes.footer')

</body>

</html>