<!DOCTYPE html>
<html>
<head>
    <title>Mapped SHGs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-3">

    <div class="card">
        <div class="card-header">
            <h4>Mapped SHGs</h4>
            <strong>Total SHGs: {{ $shgs->count() }}</strong>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>GP</th>
                        <th>Village</th>
                        <th>Venue Name</th>
                        <th>SHG Code</th>
                        <th>SHG Name</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($shgs as $shg)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $shg->gp_name }}</td>
                            <td>{{ $shg->vill_name }}</td>
                            <td>{{ $shg->venue_name }}</td>
                            <td>{{ $shg->shg_code }}</td>
                            <td>{{ $shg->shg_name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No SHGs mapped.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer text-center">
            <button class="btn btn-primary" onclick="window.print()">Print</button>
        </div>
    </div>

</div>

</body>
</html>