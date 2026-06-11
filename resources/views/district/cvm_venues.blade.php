<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Venues </title>
  @include('district.includes.header')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    @include('district.includes.navbar')
    @include('district.includes.sidebar')

    <div class="content-wrapper">

      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Venues</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('district.dashboard') }}">Home</a></li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">

          {{-- VENUES TABLE --}}
          <div class="card shadow-sm" style="border:none;border-radius:12px;overflow:hidden;">
            <div class="card-header"
              style="background:linear-gradient(135deg,#1e3a5f,#1565a0,#1e88c8);color:#fff;padding:14px 20px;">
              <h5 class="mb-0" style="font-size:15px;font-weight:700;">
                <i class="fas fa-map-marker-alt mr-2"></i>
                Venues in {{ $village->vill_name }}
              </h5>

              <small class="d-block mt-1" style="opacity:0.9;">
                {{ $village->gp_name }} | {{ $village->block_name }}
              </small>
            </div>

            <div class="card-body p-0">
              <div class="table-responsive">
                <table id="venuesTable" class="table table-bordered table-hover table-sm mb-0" style="font-size:13px;">
                  <thead class="text-center" style="background:#f0f4f8;">
                    <tr>
                      <th>#</th>
                      <th class="text-left">Venue Name</th>
                      <th>Village Name</th>
                      <th>Cadre</th>
                      <th>Capacity</th>
                      <th>Photo</th>
                      <th>Mapped Shgs</th>
                    </tr>
                  </thead>

                  <tbody>
                    @forelse($venues as $venue)
                      <tr>
                        <td class="text-center text-muted">
                          {{ $loop->iteration }}
                        </td>

                        <td class="font-weight-bold text-center">
                          {{ $venue->venue_name }}
                        </td>
                        <td class="text-center">
                          {{ $village->vill_name }}
                        </td>

                        {{-- CADRE --}}
                        <td class="text-center">
                          @if($venue->cadre_code)
                            <div style="font-weight:600;">
                              {{ $venue->mem_name }}
                            </div>
                            <small class="text-muted">
                              {{ $venue->cadre_code }}
                            </small>
                          @else
                            <span class="text-danger">
                              <i class="fas fa-user-slash mr-1"></i>Not Assigned
                            </span>
                          @endif
                        </td>

                        {{-- CAPACITY --}}
                        <td class="text-center">
                          <span class="badge badge-secondary px-2 py-1">
                            {{ $venue->capacity }}
                          </span>
                        </td>

                        {{-- PHOTO --}}
                        <td class="text-center">
                          @if($venue->photo)
                            <span class="badge badge-success px-2 py-1">
                              <i class="fas fa-check-circle mr-1"></i>Uploaded
                            </span>

                            <br>

                            <a href="{{ Storage::disk('s3')->temporaryUrl($venue->photo, now()->addMinutes(30)) }}"
                              target="_blank" class="btn btn-outline-info btn-sm mt-1">
                              <i class="fas fa-eye mr-1"></i>View Photo
                            </a>
                          @else
                            <span class="badge badge-danger px-2 py-1">
                              <i class="fas fa-times-circle mr-1"></i>Not Uploaded
                            </span>
                          @endif
                        </td>
                        <td class="text-center">
                          <a href="{{ route('district.mappedshg', $venue->venue_id) }}"
                            class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-users mr-1"></i>
                            {{ $venue->total_shg ?? 0 }} SHGs
                          </a>
                        </td>

                      </tr>
                    @empty
                      <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                          No venues found in this village.
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
    </div>

    @include('district.includes.footer')
  </div>

  <script>
    $(function () {
      $('#venueTable').DataTable({
        responsive: true, pageLength: 25,
        dom: 'Bfrtip',
        buttons: [
          { extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-success btn-sm', title: 'Village_Venues_CVM' },
          { extend: 'print', text: '<i class="fas fa-print"></i> Print', className: 'btn btn-primary btn-sm' }
        ],
        order: [[1, 'asc']]
      });
    });
  </script>
</body>

</html>