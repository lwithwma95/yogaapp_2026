<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHG Search</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow">
                <div class="card-header text-center">
                    <h4>Search SHG Members</h4>
                </div>

                <div class="card-body">

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('guest.shg.result') }}" method="GET">

                        <div class="mb-3">
                            <label class="form-label">Enter SHG Code</label>

                            <input type="text"
                                   name="shg_code"
                                   class="form-control"
                                   placeholder="Enter SHG Code"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Search
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>