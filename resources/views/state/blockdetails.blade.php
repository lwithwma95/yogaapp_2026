<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Block Details</title>
  @include('state.includes.header')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    @include('state.includes.navbar')
    @include('state.includes.sidebar')

    <div class="content-wrapper">


      <section class="content">
        <div class="container-fluid">

          <div class="card shadow-sm" style="border:none;border-radius:12px;overflow:hidden;">
            <div class="card-header"
              style="background:linear-gradient(135deg,#1e3a5f,#1565a0,#1e88c8);color:#fff;padding:14px 20px;">
              <h5 class="mb-0" style="font-size:15px;font-weight:700;">
                <i class="fas fa-map-marker-alt mr-2"></i>GP / VCDC-wise Registration
              </h5>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                @php
                  $totalGp = $gpRows->count();
                  $totalMembers = $gpRows->sum('total_member');
                  $totalReg = $gpRows->sum('total_reg');
                  $pending = $totalMembers - $totalReg;
                @endphp

                <table id="gpTable" class="table table-bordered table-hover mb-0" style="font-size:13px;">

                  <thead class="text-center" style="background:#f0f4f8;">
                    <tr>
                      <th width="5%">#</th>
                      <th class="text-center">GP / VCDC Name</th>
                      <th class="text-center">Total Members</th>
                      <th class="text-center"> Total Registered</th>
                      <th class="text-center">Pending </th>
                    </tr>
                  </thead>

                  <tbody>
                    @forelse($gpRows as $row)
                      <tr class="text-center">
                        <td class="text-muted">{{ $loop->iteration }}</td>

                        <td class="text-left font-weight-bold">
                          <a href="{{ route('state.gp.details', $row->gp_id) }}" class="text-primary">
                            <i class="fas fa-arrow-right mr-1" style="font-size:10px;"></i>
                            {{ $row->gp_name }}
                          </a>
                        </td>

                        <td>
                          <span class="badge badge-info px-2 py-1">
                            {{ number_format($row->total_member) }}
                          </span>
                        </td>
                        <td>
                          <span class="badge badge-success px-2 py-1">
                            {{ number_format($row->total_reg) }}
                          </span>
                        </td>
                        <td>
                          <span class="badge badge-danger px-2 py-1">
                            {{ number_format($row->total_member - $row->total_reg) }}
                          </span>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="3" class="text-center text-muted py-4">
                          No GP data found.
                        </td>
                      </tr>
                    @endforelse
                  </tbody>

                  {{-- ✅ FOOTER --}}
                  <tfoot style="background:#e9f2fb; font-weight:600;">

                    <td colspan="2" class="text-right">Total</td>

                    <td class="text-center">

                      {{ number_format($totalMembers) }}

                    </td>
                    <td class="text-center">

                      {{ number_format($totalReg) }}

                    </td>
                    <td class="text-center">
                      {{ number_format($pending) }}
                    </td>

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
      $('#gpTable').DataTable({
        responsive: true,
        pageLength: 25,
        dom: 'Bfrtip',
        buttons: [
          { extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-success btn-sm', title: 'Block_GP_Report' },
          { extend: 'print', text: '<i class="fas fa-print"></i> Print', className: 'btn btn-primary btn-sm' }
        ],
        order: [[1, 'asc']]
      });
    });
  </script>
</body>

</html>