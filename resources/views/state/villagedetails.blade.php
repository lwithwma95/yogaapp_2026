<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Village Details — {{ $village->vill_name }}</title>
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
              <h1 class="m-0">{{ $village->vill_name }} — SHG-wise</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('state.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">
                  <a
                    href="{{ route('state.district.details', $village->gp->block->district->district_id) }}">{{ $village->gp->block->district->district_name }}</a>
                </li>
                <li class="breadcrumb-item">
                  <a
                    href="{{ route('state.block.details', $village->gp->block->block_id) }}">{{ $village->gp->block->block_name }}</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="{{ route('state.gp.details', $village->gp->gp_id) }}">{{ $village->gp->gp_name }}</a>
                </li>
                <li class="breadcrumb-item active">{{ $village->vill_name }}</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">

          {{-- SHG TABLE WITH DRILL-DOWN TO MEMBER LIST --}}
          <div class="card shadow-sm" style="border:none;border-radius:12px;overflow:hidden;">
            <div class="card-header"
              style="background:linear-gradient(135deg,#1e3a5f,#1565a0,#1e88c8);color:#fff;padding:14px 20px;">
              <h5 class="mb-0" style="font-size:15px;font-weight:700;">
                <i class="fas fa-layer-group mr-2"></i>SHG-wise Registration &amp; Attendance —
                {{ $village->vill_name }}
              </h5>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                @php
                  $totalShg = $shgRows->count();
                  $totalMembers = $shgRows->sum('total_members');
                  $totalRegistered = $shgRows->sum('registered_members');
                  $totalNotReg = $totalMembers - $totalRegistered;
                @endphp

                <table id="shgTable" class="table table-bordered table-hover mb-0" style="font-size:13px;">

                  <thead class="text-center" style="background:#f0f4f8;">
                    <tr>
                      <th width="4%">#</th>
                      <th class="text-left">SHG Name</th>
                      <th width="10%">SHG Code</th>
                      <th width="8%">Total</th>
                      <th width="10%">Registered</th>
                      <th width="12%">Not Registered</th>
                      <th width="10%">Details</th>
                    </tr>
                  </thead>

                  <tbody>
                    @forelse($shgRows as $row)
                      @php
                        $notReg = $row->total_members - $row->registered_members;
                      @endphp

                      <tr class="text-center">
                        <td class="text-muted">{{ $loop->iteration }}</td>

                        <td class="text-left font-weight-bold">
                          {{ $row->shg_name }}
                        </td>

                        <td>
                          <small class="text-muted">{{ $row->shg_code }}</small>
                        </td>

                        <td>
                          <span class="badge badge-secondary px-2 py-1">
                            {{ number_format($row->total_members) }}
                          </span>
                        </td>

                        <td>
                          <span class="badge badge-success px-2 py-1">
                            {{ number_format($row->registered_members) }}
                          </span>
                        </td>

                        <td>
                          <span class="badge badge-danger px-2 py-1">
                            {{ number_format($notReg) }}
                          </span>
                        </td>

                        <td>
                          <a href="{{ route('state.shg.details', $row->shg_code) }}"
                            class="btn btn-xs btn-outline-primary" style="font-size:11px;">
                            <i class="fas fa-users mr-1"></i>Members
                          </a>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                          No SHG data found.
                        </td>
                      </tr>
                    @endforelse
                  </tbody>

                  {{-- ✅ FOOTER --}}
                  <tfoot style="background:#e9f2fb; font-weight:600;">
                    <tr class="text-center">

                      <td colspan="3" class="text-right">TOTAL</td>

                      <td>
                        <span class="badge badge-secondary px-2 py-1">
                          {{ number_format($totalMembers) }}
                        </span>
                      </td>

                      <td>
                        <span class="badge badge-success px-2 py-1">
                          {{ number_format($totalRegistered) }}
                        </span>
                      </td>

                      <td>
                        <span class="badge badge-danger px-2 py-1">
                          {{ number_format($totalNotReg) }}
                        </span>
                      </td>

                      <td>
                        <span class="badge badge-dark px-2 py-1">
                          {{ number_format($totalShg) }} SHGs
                        </span>
                      </td>

                    </tr>
                  </tfoot>

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
      $('#shgTable').DataTable({
        responsive: true,
        pageLength: 25,
        dom: 'Bfrtip',
        buttons: [
          { extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-success btn-sm', title: 'Village_SHG_Report' },
          { extend: 'print', text: '<i class="fas fa-print"></i> Print', className: 'btn btn-primary btn-sm' }
        ],
        order: [[1, 'asc']]
      });
    });
  </script>
</body>

</html>