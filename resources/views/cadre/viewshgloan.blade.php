<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All SHG Loans</title>

    @include('cadre.includes.header')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        @include('cadre.includes.navbar')

        @include('cadre.includes.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">


            <section class="content-header">
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

                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>SHG Loan Details</h1>
                        </div>

                        <div class="col-sm-6 text-right">
                            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>

                </div>
            </section>

            <section class="content">

                <div class="container-fluid">

                    <div class="card card-primary">

                        <div class="card-header">
                            <h3 class="card-title">
                                Loan Information
                            </h3>

                            <div class="card-tools">

                                <button class="btn btn-warning btn-sm" data-toggle="modal"
                                    data-target="#paymentModal{{ $loan->id }}">
                                    <i class="fas fa-money-bill"></i>
                                    Add Payment
                                </button>

                            </div>
                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-4">
                                    <strong>SHG Name</strong>
                                    <p>{{ $loan->shg->name }}</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>SHG Code</strong>
                                    <p>{{ $loan->shg_code }}</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>CLF</strong>
                                    <p>{{ $loan->shg->clf }}</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>VO</strong>
                                    <p>{{ $loan->shg->vo }}</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>GP / VCDC</strong>
                                    <p>{{ $loan->shg->gp }}</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>Village</strong>
                                    <p>{{ $loan->shg->village }}</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>Loan Number</strong>
                                    <p>{{ $loan->loan_number }}</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>Loan Amount</strong>
                                    <p>₹ {{ number_format($loan->loan_amount, 2) }}</p>
                                </div>

                                <div class="col-md-4">
                                    <strong>Already Paid</strong>
                                    <p>₹ {{ number_format($loan->already_paid, 2) }}</p>
                                </div>

                                <div class="col-md-4">
                                    <strong>Total Due</strong>
                                    <p>₹ {{ number_format($loan->total_due, 2) }}</p>
                                </div>

                                <div class="col-md-4">
                                    <strong>Bank</strong>
                                    <p>{{ $loan->bank }}</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>Bank Account Number</strong>
                                    <p>{{ $loan->bank_acc_no }}</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>IFSC Code</strong>
                                    <p>{{ $loan->ifsc }}</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>Loan Sanction Date</strong>
                                    <p>{{ \Carbon\Carbon::parse($loan->loan_sanction_date)->format('d-m-Y') }}</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>Due Date</strong>
                                    <p>{{ \Carbon\Carbon::create()->day($loan->due_date)->format('jS') }} of every month</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>Bank Sakhi</strong>
                                    <p>{{ $loan->bankSakhi?->name }}</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>Status</strong>

                                    @if($loan->status == 'Running')
                                        <span class="badge badge-warning">
                                            Running
                                        </span>
                                    @else
                                        <span class="badge badge-success">
                                            Loan Closed
                                        </span>
                                    @endif
                                </div>

                            </div>

                        </div>
                    </div>

                    <!-- Payment History -->

                    <div class="card card-primary">

                        <div class="card-header">
                            <h3 class="card-title">
                                Payment History
                            </h3>
                        </div>

                        <div class="card-body table-responsive">

                            <table class="table table-bordered table-striped table-sm">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Month</th>
                                        <th>Payment Amount</th>
                                        <th>Date of Payment</th>
                                        <th>Payment Added by</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse($loan->payments as $key => $payment)

                                        <tr>

                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                {{ $payment->name ?? 'N/A' }}
                                            </td>

                                            <td>
                                                ₹ {{ number_format($payment->payment_amount, 2) }}
                                            </td>

                                            <td>
                                                {{ \Carbon\Carbon::parse($payment->date_of_payment)->format('d-m-Y') }}
                                            </td>
                                            <td>
                                                {{ $payment->updated_by ? $payment->updatedBy->name . ' (' . $payment->updatedBy->designation . ')' : 'N/A' }}
                                            </td>

                                            <td>
                                                {{ $payment->created_at->timezone('Asia/Kolkata')->format('d-m-Y h:i A') }}
                                            </td>

                                        </tr>

                                    @empty

                                        <tr>
                                            <td colspan="6" class="text-center">
                                                No Payments Found
                                            </td>
                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>
                    </div>

                </div>

            </section>

        </div>

        <!-- Payment Modal -->

        <div class="modal fade" id="paymentModal{{ $loan->id }}">
            <div class="modal-dialog">
                <div class="modal-content ">
                    <form action="{{ route('cadre.shgloan.payment.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title">
                                Add Loan Payment
                            </h4>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="loan_id" value="{{ $loan->id }}">
                            <div class="form-group">
                                <label>Month</label>
                                <input type="text" name="month" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Payment Amount</label>
                                <input type="number" step="0.01" name="payment_amount" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Date of Payment</label>
                                <input type="date" name="date_of_payment" class="form-control" required>
                            </div>
                        </div>

                        <div class="modal-footer">

                            <button type="submit" class="btn btn-success">

                                Submit Payment

                            </button>

                        </div>

                    </form>

                </div>
            </div>
        </div>
        <!-- /.content-wrapper -->

        @include('cadre.includes.footer')

</body>

</html>