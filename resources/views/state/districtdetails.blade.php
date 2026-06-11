<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  @include('state.includes.header')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    @include('state.includes.navbar')
    @include('state.includes.sidebar')

    <div class="content-wrapper">


      <section class="content">
        <div class="container-fluid">

          @php
            $total_member = 0;
            $total_reg = 0;
            $total_pend= 0;
          @endphp



          <div class="card shadow-sm" style="border:none;border-radius:12px;overflow:hidden;">
            <div class="card-header"
              style="background:linear-gradient(135deg,#1e3a5f,#1565a0,#1e88c8);color:#fff;padding:14px 20px;">
              <h5 class="mb-0" style="font-size:15px;font-weight:700;">
                <i class="fas fa-th-list mr-2"></i>
                Block-wise Registration & Attendance
              </h5>
            </div>

            <div class="card-body p-0">
              <div class="table-responsive">

                <table id="blockTable" class="table table-bordered table-hover mb-0" style="font-size:13px;">

                  <thead class="text-center" style="background:#f0f4f8;">
                    <tr>
                      <th width="5%">#</th>
                      <th class="text-left">Block Name</th>
                      <th width="10%">Total Members</th>
                      <th width="10%">Registered Members</th>
                      <th width="10%">Pending</th>
                    </tr>
                  </thead>

                  <tbody>
                    @forelse($blocks as $row)
                      <tr class="text-center">
                        <td class="text-muted">{{ $loop->iteration }}</td>

                        <td class="text-left font-weight-bold">
                          <a href="{{ route('state.block.details', $row->block_id) }}" class="text-primary">
                            <i class="fas fa-arrow-right mr-1" style="font-size:10px;"></i>
                            {{ $row->block_name }}
                          </a>
                        </td>

                        <td>
                          <span class="badge badge-secondary px-2 py-1">
                            {{ number_format($row->total_member) }}@php $total_member += $row->total_member; @endphp
                          </span>
                        </td>

                        <td>
                          <span class="badge badge-info px-2 py-1">
                            {{ number_format($row->total_reg) }}@php $total_reg += $row->total_reg; @endphp
                          </span>
                        </td>
                        <td>
                          <span class="badge badge-info px-2 py-1">
                            @php $pend = ($row->total_member)-($row->total_reg); echo $pend;  $total_pend +=$pend; @endphp
                          </span>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                          No block data found.
                        </td>
                      </tr>

                    @endforelse
                  </tbody>

                  {{-- ✅ FOOTER --}}
                  <tfoot style="background:#e9f2fb; font-weight:600;">
                    <tr class="text-center">
                      <td colspan="2" class="text-right">TOTAL</td>

                      <td>
                        <span class="badge badge-secondary px-2 py-1">
                          {{ number_format($total_member) }}
                        </span>
                      </td>

                      <td>
                        <span class="badge badge-info px-2 py-1">
                          {{ number_format($total_reg) }}
                        </span>
                      </td>
                      <td>
                        <span class="badge badge-info px-2 py-1">
                          {{ number_format($total_pend) }}
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
      $('#blockTable').DataTable({
        responsive: true,
        pageLength: 25,
        dom: 'Bfrtip',
        buttons: [
          { extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-success btn-sm', title: 'District_Block_Report' },
          { extend: 'print', text: '<i class="fas fa-print"></i> Print', className: 'btn btn-primary btn-sm' }
        ],
        order: [[1, 'asc']]
      });
    });
  </script>
</body>

</html>