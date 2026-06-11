<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Block Cadres</title>
    <style>
        /* Input Field */
        .form-control {
            height: 48px;
            border: none !important;

            background: rgba(255, 255, 255, 0.8585) !important;
            color: #000 !important;

            font-size: 15px;
            font-weight: 500;
        }

        /* Placeholder */
        .form-control::placeholder {
            color: #555 !important;
        }

        /* Focus */
        .form-control:focus {
            background: rgba(255, 255, 255, 0.95) !important;
            color: #000 !important;
            box-shadow: none !important;
        }

        /* Chrome / Edge Autofill Fix */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {

            -webkit-text-fill-color: #000 !important;

            -webkit-box-shadow:
                0 0 0px 1000px rgba(255, 255, 255, 0.90) inset !important;

            box-shadow:
                0 0 0px 1000px rgba(255, 255, 255, 0.90) inset !important;

            caret-color: #000 !important;

            border: none !important;

            transition: background-color 5000s ease-in-out 0s;
        }

        /* Password dots visibility */
        input[type="password"] {
            color: #000 !important;
        }
    </style>
    @include('block.includes.header')
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        @include('block.includes.navbar')

        @include('block.includes.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <section class="content-header">
                <div class="container-fluid">
                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                                <span aria-hidden="true">&times;</span>
                            </button>

                            <i class="fas fa-check-circle mr-1"></i>
                            {{ session('success') }}

                        </div>
                    @endif

                    {{-- Error Message --}}
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                                <span aria-hidden="true">&times;</span>
                            </button>

                            <i class="fas fa-times-circle mr-1"></i>
                            {{ session('error') }}

                        </div>
                    @endif

                    {{-- Validation Errors --}}
                    @if ($errors->any())

                        <div class="alert alert-danger alert-dismissible fade show" role="alert">

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                                <span aria-hidden="true">&times;</span>
                            </button>

                            <i class="fas fa-exclamation-triangle mr-1"></i>

                            <strong>Please fix the following errors:</strong>

                            <ul class="mb-0 mt-2">

                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach

                            </ul>

                        </div>

                    @endif

                    <div class="row mb-2">

                        <div class="col-sm-6">
                            <h1>Block Admin Cadres<h1>
                        </div>

                        <div class="col-sm-6 text-right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">

                                <i class="fas fa-plus"></i> Add Cadres
                            </button>
                        </div>

                    </div>

                </div>
            </section>

            <section class="content">

                <div class="container-fluid">

                    <div class="card">

                        <div class="card-body table-responsive">

                            <table id="shgTable" class="table table-bordered table-hover table-sm">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>District</th>
                                        <th>Block</th>
                                        <th>Designation</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach($users as $key => $user)

                                        <tr>

                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->district }}</td>
                                            <td>{{ $user->block }}</td>
                                            <td>{{ $user->designation }}</td>

                                            <td>
                                                <button class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#viewModal{{ $user->id }}">

                                                    <i class="fas fa-eye"></i>
                                                </button>
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

        <!-- Add User Modal -->
        <div class="modal fade" id="addUserModal" tabindex="-1">

            <div class="modal-dialog modal-lg">

                <div class="modal-content">

                    <form action="{{ route('block.cadres.store') }}" method="POST">

                        @csrf

                        <div class="modal-header bg-success">

                            <h5 class="modal-title">
                                Add Block Cadre
                            </h5>

                            <button type="button" class="close" data-dismiss="modal">

                                <span>&times;</span>
                            </button>

                        </div>

                        <div class="modal-body">

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label>Name</label>

                                    <input type="text" name="name" class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Email</label>

                                    <input type="email" name="email" class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Password</label>

                                    <input type="password" name="password" class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Designation</label>

                                    <select name="designation" class="form-control" required>
                                        <option value="">Select Designation</option>
                                        <option value="Jeevika Sakhi">Jeevika Sakhi</option>
                                        <option value="Krishi Sakhi">Krishi Sakhi</option>
                                        <option value="Pashu Sakhi">Pashu Sakhi</option>
                                        <option value="Bank Sakhi">Bank Sakhi</option>
                                        <option value="CRP-EP">CRP-EP</option>
                                        <option value="Bima Sakhi">Bima Sakhi</option>
                                        <option value="Yuva Sakhi">Yuva Sakhi</option>
                                    </select>
                                </div>

                            </div>

                        </div>

                        <div class="modal-footer">

                            <button type="submit" class="btn btn-primary">

                                <i class="fas fa-save"></i> Save User
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>
        <!-- /.content-wrapper -->

        @include('block.includes.footer')

</body>

</html>