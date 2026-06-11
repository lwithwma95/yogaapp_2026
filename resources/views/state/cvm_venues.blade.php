<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Venues — {{ $village->vill_name }}</title>
  @include('state.includes.header')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  @include('state.includes.navbar')
  @include('state.includes.sidebar')

  <div class="content-wrapper">

    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">{{ $village->vill_name }} — Venues</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('state.dashboard') }}">Home</a></li>
              
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">

        @php
          $totalVenues   = $venues->count();
          $totalUploaded = $venues->filter(fn($v) => $v->photo)->count();
          $totalNot      = $totalVenues - $totalUploaded;
        @endphp

        {{-- VILLAGE BANNER --}}
        <div class="card mb-3" style="border:none;border-radius:12px;background:linear-gradient(135deg,#155724,#1a6b2e,#28a745);color:#fff;">
          <div class="card-body py-3 px-4">
            <div class="d-flex align-items-center">
              <i class="fas fa-home fa-2x mr-3" style="opacity:.85"></i>
              <div>
                <div style="font-size:11px;opacity:.75;text-transform:uppercase;letter-spacing:.6px;">
                  {{ $village->gp->block->district->district_name }} &rsaquo; {{ $village->gp->block->block_name }} &rsaquo; {{ $village->gp->gp_name }}
                </div>
                <div style="font-size:1.3rem;font-weight:800;">{{ $village->vill_name }}</div>
              </div>
            </div>
          </div>
        </div>

       

        {{-- VENUES TABLE --}}
        <div class="card shadow-sm" style="border:none;border-radius:12px;overflow:hidden;">
          <div class="card-header" style="background:linear-gradient(135deg,#1e3a5f,#1565a0,#1e88c8);color:#fff;padding:14px 20px;">
            <h5 class="mb-0" style="font-size:15px;font-weight:700;">
              <i class="fas fa-map-marker-alt mr-2"></i>Venue List — {{ $village->vill_name }}
            </h5>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table id="venueTable" class="table table-bordered table-hover mb-0" style="font-size:13px;">
                <thead class="text-center" style="background:#f0f4f8;">
                  <tr>
                    <th width="5%">#</th>
                    <th class="text-left">Venue Name</th>
                    <th>Village</th>
                    <th width="22%">Cadre</th>
                    <th width="11%" class="text-center">Capacity</th>
                    <th width="16%" class="text-center">Venue Photo</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($venues as $venue)
                    <tr>
                      <td class="text-center text-muted">{{ $loop->iteration }}</td>
                      <td class="font-weight-bold">{{ $venue->venue_name }}</td>
                      <td class="font-weight-bold">{{ $venue->village->vill_name }}</td>
                      <td>
                        @if($venue->cadre)
                          <div style="font-size:13px;font-weight:600">{{ $venue->cadre->mem_name }}</div>
                          <small class="text-muted">{{ $venue->cadre->mem_code }}</small>
                        @else
                          <span class="text-danger" style="font-size:12px;">
                            <i class="fas fa-exclamation-circle mr-1"></i>Not Assigned
                          </span>
                        @endif
                      </td>
                      <td class="text-center">
                        <span class="badge badge-secondary px-2 py-1">{{ $venue->capacity }}</span>
                      </td>
                      <td class="text-center">
                        @if($venue->photo)
                          <span class="badge badge-success px-2 py-1" style="font-size:11px;">
                            <i class="fas fa-check-circle mr-1"></i>Uploaded
                          </span>
                          <br>
                          <a href="{{ Storage::disk('s3')->temporaryUrl($venue->photo, now()->addMinutes(30)) }}"
                             target="_blank"
                             class="btn btn-outline-info btn-sm mt-1" style="font-size:11px;">
                            <i class="fas fa-eye mr-1"></i>View Photo
                          </a>
                        @else
                          <span class="badge badge-danger px-2 py-1" style="font-size:11px;">
                            <i class="fas fa-times-circle mr-1"></i>Not Uploaded
                          </span>
                        @endif
                      </td>
                    </tr>
                  @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No venues found for this village.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
    </section>
  </div>

  @include('state.includes.footer')
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
