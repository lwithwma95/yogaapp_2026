```blade
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        View Assigned SHGs
    </title>

    @include('cadre.includes.header')

</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

    <div class="wrapper">

        @include('cadre.includes.navbar')

        @include('cadre.includes.sidebar')

        {{-- CONTENT WRAPPER --}}

        <div class="content-wrapper">

            {{-- PAGE HEADER --}}

            <div class="content-header">

                <div class="container-fluid">

                    <div class="row mb-2">

                        <div class="col-sm-6">

                            <h1 class="m-0">
                                View Assigned SHGs
                            </h1>

                        </div>

                        <div class="col-sm-6">

                            <ol class="breadcrumb float-sm-right">

                                <li class="breadcrumb-item">

                                    <a href="{{ route('cadre.dashboard') }}">
                                        Home
                                    </a>

                                </li>

                                <li class="breadcrumb-item active">
                                    Assigned SHGs
                                </li>

                            </ol>

                        </div>

                    </div>

                </div>

            </div>

            {{-- MAIN CONTENT --}}

            <section class="content">

                <div class="container-fluid">

                    {{-- SUCCESS MESSAGE --}}

                    @if(session('success'))

                        <div class="alert alert-success alert-dismissible fade show">

                            <button type="button" class="close" data-dismiss="alert">

                                &times;

                            </button>

                            <i class="fas fa-check-circle"></i>

                            {{ session('success') }}

                        </div>

                    @endif

                    {{-- ERROR MESSAGE --}}

                    @if(session('error'))

                        <div class="alert alert-danger alert-dismissible fade show">

                            <button type="button" class="close" data-dismiss="alert">

                                &times;

                            </button>

                            <i class="fas fa-times-circle"></i>

                            {{ session('error') }}

                        </div>

                    @endif

                    <div class="card card-primary card-outline">

                        {{-- CARD HEADER --}}

                        <div class="card-header bg-light">

                            <div class="text-center w-100">

                                <h4 class="mb-1 text-primary font-weight-bold">

                                    <i class="fas fa-building mr-2"></i>

                                    Venue :
                                    {{ $venue->venue_name ?? 'N/A' }}

                                </h4>

                                <p class="mb-1 text-muted">

                                    View All SHGs Assigned Under This Venue

                                </p>

                                <span class="badge badge-warning p-2">

                                    <i class="fas fa-user mr-1"></i>

                                    Cadre :
                                    {{ $memberName }}

                                </span>

                            </div>

                        </div>

                        {{-- CARD BODY --}}

                        <div class="card-body">

                            <div class="table-responsive">

                                <table id="shgTable" class="table table-bordered table-hover table-sm table-striped">

                                    <thead class="bg-primary text-white">

                                        <tr>

                                            <th width="10%">
                                                Sl No
                                            </th>

                                            <th>
                                                SHG Name
                                            </th>

                                            <th width="25%">
                                                Status
                                            </th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @forelse($shgs as $shg)

                                            <tr>
                                                <td class="text-center">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>
                                                    {{ $shg->shg_name }} ({{ $shg->shg_code }})
                                                </td>
                                                <td>
                                                    @php
                                                        $registeredCount = \App\Models\ShgMember::where(
                                                            'shg_code',
                                                            $shg->shg_code
                                                        )
                                                            ->where(
                                                                'yoga2026_registration',
                                                                1
                                                            )
                                                            ->count();

                                                        $totalCount = \App\Models\ShgMember::where(
                                                            'shg_code',
                                                            $shg->shg_code
                                                        )->count();

                                                    @endphp

                                                    @if($registeredCount > 0)

                                                        <span class="badge badge-success p-2">

                                                            {{ $registeredCount }} / {{ $totalCount }}
                                                            Registered

                                                        </span>

                                                    @else

                                                        <span class="badge badge-danger p-2">

                                                            No Registration

                                                        </span>

                                                    @endif

                                                </td>

                                            </tr>

                                        @empty

                                            <tr>

                                                <td colspan="3" class="text-center text-danger">

                                                    No SHGs Assigned

                                                </td>

                                            </tr>

                                        @endforelse

                                    </tbody>

                                </table>

                            </div>

                        </div>


                    </div>

                </div>

            </section>
            <br>
            <br>

        </div>

        {{-- FOOTER --}}

        @include('cadre.includes.footer')

    </div>

</body>

</html>
```