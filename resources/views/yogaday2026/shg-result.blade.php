<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHG Members</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">

    <div class="card shadow mb-4">
        <div class="card-header">
            <h4>SHG Details</h4>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-md-6 mb-2">
                    <strong>SHG Name:</strong> {{ $shg->name }}
                </div>

                <div class="col-md-6 mb-2">
                    <strong>SHG Code:</strong> {{ $shg->shg_code }}
                </div>

                <div class="col-md-6 mb-2">
                    <strong>President:</strong> {{ $shg->president }}
                </div>

                <div class="col-md-6 mb-2">
                    <strong>Secretary:</strong> {{ $shg->secretary }}
                </div>

                <div class="col-md-6 mb-2">
                    <strong>Village:</strong> {{ $shg->village }}
                </div>

                <div class="col-md-6 mb-2">
                    <strong>GP:</strong> {{ $shg->gp }}
                </div>

                <div class="col-md-6 mb-2">
                    <strong>Block:</strong> {{ $shg->block }}
                </div>

                <div class="col-md-6 mb-2">
                    <strong>District:</strong> {{ $shg->district }}
                </div>
            </div>

        </div>
    </div>

    <div class="card shadow">

        <div class="card-header">
            <h4>SHG Member List</h4>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-striped">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Member Name</th>
                        <th>Member Code</th>
                        <th>Designation</th>
                        <th>Marital Status</th>
                        <th>DOB</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($members as $key => $member)

                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $member->member_name }}</td>
                            <td>{{ $member->member_code }}</td>
                            <td>{{ $member->designation }}</td>
                            <td>{{ $member->marital_status }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($member->dob)->format('d-m-Y') }}
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="text-center">
                                No Members Found
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>

</body>
</html>