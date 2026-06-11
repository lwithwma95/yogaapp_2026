<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Member Attendance</title>

    @include('cadre.includes.header')

    <style>
        /* ── Attendance pill button ── */
        .att-btn {
            min-width: 130px;
            padding: 9px 18px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .att-btn.is-present {
            background-color: #28a745;
            border-color: #28a745;
            color: #fff;
        }

        .att-btn.is-present:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        /* ── Member card ── */
        .member-card {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
            background: #fff;
            transition: background 0.2s ease, border-color 0.2s ease;
        }

        .member-card.is-present {
            background: #d4edda;
            border-color: #8fd19e;
        }

        .member-serial {
            min-width: 30px;
            font-weight: 700;
            font-size: 14px;
            color: #6c757d;
            text-align: center;
        }

        .member-info {
            flex: 1;
            min-width: 0;
        }

        .member-name {
            font-weight: 600;
            font-size: 15px;
            color: #212529;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .member-code {
            font-size: 12px;
            color: #6c757d;
            margin-top: 1px;
        }

        /* ── Stats bar ── */
        .stats-bar {
            background: #e9f7ea;
            border: 1px solid #c3e6cb;
            border-radius: 10px;
            padding: 10px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 14px;
        }

        .stats-pill {
            font-size: 13px;
            font-weight: 600;
            color: #155724;
        }

        .present-count-badge {
            background: #28a745;
            color: #fff;
            border-radius: 50px;
            padding: 3px 12px;
            font-size: 13px;
            font-weight: 700;
        }

        /* ── Sticky submit footer ── */
        .sticky-submit {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1050;
            background: #fff;
            border-top: 2px solid #28a745;
            padding: 10px 20px;
            display: none;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            box-shadow: 0 -4px 16px rgba(0, 0, 0, 0.10);
        }

        .sticky-submit.visible {
            display: flex;
        }

        .sticky-submit-label {
            font-size: 14px;
            font-weight: 600;
            color: #155724;
        }

        /* Bottom padding so sticky bar doesn't cover last card */
        #memberList {
            padding-bottom: 80px;
        }

        /* Empty / loading state */
        .list-placeholder {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
            font-size: 15px;
        }

        @media (max-width: 480px) {
            .att-btn {
                min-width: 110px;
                padding: 8px 12px;
                font-size: 12px;
            }

            .member-name {
                font-size: 14px;
            }
        }

        .custom-switch-lg {
            padding-left: 4rem;
        }

        .custom-switch-lg .custom-control-label::before {
            left: -4rem;
            width: 3.2rem;
            height: 1.8rem;
            border-radius: 2rem;
        }

        .custom-switch-lg .custom-control-label::after {
            top: calc(0.25rem + 2px);
            left: calc(-4rem + 2px);
            width: 1.4rem;
            height: 1.4rem;
            border-radius: 50%;
        }

        .custom-switch-lg .custom-control-input:checked~.custom-control-label::after {
            transform: translateX(1.4rem);
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        @include('cadre.includes.navbar')
        @include('cadre.includes.sidebar')

        <div class="content-wrapper">

            {{-- PAGE HEADER --}}
            <div class="content-header">
                <div class="container-fluid">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-2">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mt-2">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="fas fa-times-circle mr-1"></i> {{ session('error') }}
                        </div>
                    @endif

                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Add Attendance</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('cadre.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">Add Attendance</li>
                            </ol>
                        </div>
                    </div>

                    {{-- Venue Banner --}}
                    @if(isset($venue) && $venue)
                        <div class="card mb-3"
                            style="border:none;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.08);">
                            <div class="card-header d-flex align-items-center justify-content-between flex-wrap"
                                style="background:linear-gradient(135deg,#1a3c2e 0%,#14532d 60%,#1a6b3c 100%);color:#fff;padding:14px 20px;gap:8px;">
                                <div>
                                    <div style="font-size:10px;opacity:.75;text-transform:uppercase;letter-spacing:.5px;">
                                        Marking attendance for venue</div>
                                    <div style="font-weight:800;font-size:1.1rem;margin-top:3px;">
                                        <i class="fas fa-map-marker-alt mr-2"></i>{{ $venue->venue_name }}
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap" style="gap:6px;">
                                    <span class="badge badge-light text-dark px-2 py-1">
                                        <i class="fas fa-user mr-1"></i>{{ $memberName ?? 'N/A' }}
                                    </span>
                                    <span class="badge badge-light text-dark px-2 py-1">
                                        <i class="fas fa-users mr-1"></i>Capacity: {{ $venue->capacity }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

            {{-- MAIN CONTENT --}}
            <section class="content">
                <div class="container-fluid">

                    <form action="{{ route('cadre.attendance.store') }}" method="POST">
                        @csrf

                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    Attendance of {{ $members->first()->shg_name ?? '' }}
                                </h5>
                            </div>

                            <div class="card-body p-0">
                                <table class="table table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Member Name</th>
                                            <th>Guardian Name</th>
                                            <th width="15%">Attendance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($members as $member)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $member->mem_name }} ({{ $member->mem_code }})</td>
                                                <td>{{ $member->mem_guard_name }}</td>
                                                <input type="hidden" name="member_codes[]" value="{{ $member->mem_code }}">
                                                <td class="text-center">
                                                    @if($member->yoga2026_registration == 1)
                                                        <div class="custom-control custom-switch custom-switch-lg">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="member{{ $member->mem_code }}" name="attendance[]"
                                                                value="{{ $member->mem_code }}" {{ $member->yoga_attendance ? 'checked' : '' }}>

                                                            <label class="custom-control-label"
                                                                for="member{{ $member->mem_code }}">
                                                            </label>
                                                        </div>
                                                    @else
                                                        <span class="badge badge-danger px-2 py-1">
                                                            Not Registered
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">
                                                    No members found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>

                                    @if($members->count())
                                        <tfoot>
                                            <tr class="font-weight-bold bg-light">
                                                <td colspan="3" class="text-right">
                                                    Total Members
                                                </td>
                                                <td class="text-center">
                                                    {{ $members->count() }}
                                                </td>
                                            </tr>
                                        </tfoot>
                                    @endif
                                </table>
                            </div>

                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save mr-1"></i>
                                    Submit Attendance
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </section>

        </div>

        @include('cadre.includes.footer')

    </div>



</body>

</html>