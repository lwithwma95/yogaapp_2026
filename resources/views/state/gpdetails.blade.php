<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GP Details — {{ $gp->gp_name }}</title>
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
              <h1 class="m-0">{{ $gp->gp_name }} — Village-wise</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('state.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">
                  <a
                    href="{{ route('state.district.details', $gp->block->district->district_id) }}">{{ $gp->block->district->district_name }}</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="{{ route('state.block.details', $gp->block->block_id) }}">{{ $gp->block->block_name }}</a>
                </li>
                <li class="breadcrumb-item active">{{ $gp->gp_name }}</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">

          <div class="card shadow-sm" style="border:none;border-radius:12px;overflow:hidden;">
            <div class="card-header"
              style="background:linear-gradient(135deg,#1e3a5f,#1565a0,#1e88c8);color:#fff;padding:14px 20px;">
              <h5 class="mb-0" style="font-size:15px;font-weight:700;">
                <i class="fas fa-home mr-2"></i>Village-wise Registration &amp; Attendance — {{ $gp->gp_name }}
              </h5>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                @php
                  $totalVillages = $villageRows->count();
                  $totalShg = $villageRows->sum('total_shg');
                  $totalMembers = $villageRows->sum('total_members');
                  $totalReg = $villageRows->sum('registered_members');
                @endphp

                <table id="villTable" class="table table-bordered table-hover mb-0" style="font-size:13px;">

                  <thead class="text-center" style="background:#f0f4f8;">
                    <tr>
                      <th width="5%">#</th>
                      <th class="text-left">Village Name</th>
                      <th width="8%">SHGs</th>
                      <th width="10%">Members</th>
                      <th width="12%">Registered</th>
                    </tr>
                  </thead>

                  <tbody>
                    @forelse($villageRows as $row)
                      <tr class="text-center">
                        <td class="text-muted">{{ $loop->iteration }}</td>

                        <td class="text-left font-weight-bold">
                          <a href="{{ route('state.village.details', $row->vill_id) }}" class="text-primary">
                            <i class="fas fa-arrow-right mr-1" style="font-size:10px;"></i>
                            {{ $row->vill_name }}
                          </a>
                        </td>

                        <td>
                          <span class="badge badge-info px-2 py-1">
                            {{ number_format($row->total_shg) }}
                          </span>
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
                      </tr>
                    @empty
                      <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                          No village data found.
                        </td>
                      </tr>
                    @endforelse
                  </tbody>

                  {{-- ✅ FOOTER --}}
                  <tfoot style="background:#e9f2fb; font-weight:600;">
                    <tr class="text-center">

                      <td colspan="2" class="text-right">TOTAL</td>

                      <td>
        
                        <span class="badge badge-dark px-2 py-1">
                          {{ number_format($totalShg) }}
                        </span>
                      </td>

                      <td>
     
                        <span class="badge badge-info px-2 py-1">
                          {{ number_format($totalMembers) }}
                        </span>
                      </td>

                      <td>
      

                        <span class="badge badge-secondary px-2 py-1">
                           {{ number_format($totalReg) }}
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
      $('#villTable').DataTable({
        responsive: true,
        pageLength: 25,
        dom: 'Bfrtip',
        buttons: [
          { extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-success btn-sm', title: 'GP_Village_Report' },
          { extend: 'print', text: '<i class="fas fa-print"></i> Print', className: 'btn btn-primary btn-sm' }
        ],
        order: [[1, 'asc']]
      });
    });
  </script>
</body>

</html>