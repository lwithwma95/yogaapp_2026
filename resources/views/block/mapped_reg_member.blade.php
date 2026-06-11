<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Registered Members</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    @media print {
        .card-footer {
            display: none !important;
        }

        .btn {
            display: none !important;
        }

        body {
            margin: 0;
            padding: 0;
        }
    }
</style>

<body>

    <div class="container-fluid mt-4">

        <div class="card">
            <div class="card-header">
                <h4>Registered Members</h4>
                <strong>GP:</strong> {{ urldecode($gp_name) }}
                |
                <strong>Village:</strong> {{ urldecode($village_name) }}
                |
                <strong>Venue Name:</strong> {{ urldecode($venue_name) }}
                |
                <strong>Total Registered:</strong> {{ $members->count() }}
            </div>

            <div class="card-body">

                @if($members->count())
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>

                                    <th>SHG Code</th>
                                    <th>SHG Name</th>
                                    <th>Member Name</th>
                                    <th>Mobile</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($members as $member)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $member->shg_code }}</td>
                                        <td>{{ $member->shg_name }}</td>
                                        <td>{{ $member->mem_name ?? '-' }}</td>
                                        <td>{{ $member->mem_mobile ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning mb-0">
                        No registered members found.
                    </div>
                @endif

            </div>
            <div class="card-footer text-center">
                <button type="button" class="btn btn-primary" onclick="window.print();">
                    Print
                </button>

                <button type="button" class="btn btn-secondary" onclick="window.close();">
                    Close
                </button>
            </div>
        </div>

    </div>

</body>


</html>