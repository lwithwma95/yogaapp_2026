<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Block Details </title> 
  @include('district.includes.header')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  @include('district.includes.navbar')
  @include('district.includes.sidebar')
<br>
  <div class="content-wrapper">
    

    <section class="content">
      <div class="container-fluid">

        

       

        {{-- GP TABLE --}}
        <div class="card shadow-sm" style="border:none;border-radius:12px;overflow:hidden;">
          <div class="card-header" style="background:linear-gradient(135deg,#1e3a5f,#1565a0,#1e88c8);color:#fff;padding:14px 20px;">
            <h5 class="mb-0" style="font-size:15px;font-weight:700;">
              <i class="fas fa-map-marker-alt mr-2"></i>GP / VCDC-wise Registration &amp; Attendance
            </h5>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table id="gpTable" class="table table-bordered table-hover mb-0" style="font-size:13px;">
                <thead class="text-center" style="background:#f0f4f8;">
                  <tr>
                    <th width="5%">#</th>
                    <th class="text-left">GP / VCDC Name</th>
                    <th width="12%">Total</th>
                    <th width="12%">Registered</th>
                    <th width="12%">Not Reg.</th>
                    <th width="14%">% Reg.</th>
                    <th width="12%">Attended</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $total      = 0;
                    $registered = 0;
                    $notReg     = 0;
                    $percent    = 0;
                    $totalAttendance = 0;
                  @endphp
                  @forelse($gpRows as $row)
                    @php
                      $nr  = $row->total - $row->registered;
                      $pct = $row->total > 0 ? round(($row->registered / $row->total) * 100, 1) : 0;
                    @endphp
                    <tr class="text-center">
                      <td class="text-muted">{{ $loop->iteration }}</td>
                      <td class="text-left font-weight-bold">
                        <a href="{{ route('district.gp.details', $row->gp_id) }}" class="text-primary">
                          <i class="fas fa-arrow-right mr-1" style="font-size:10px;"></i>{{ $row->gp_name }}
                        </a>
                      </td>
                      <td><span class="badge badge-primary px-2 py-1">{{ number_format($row->total) }}</span> @php $total += $row->total; @endphp</td>
                      <td><span class="badge badge-success px-2 py-1">{{ number_format($row->registered) }}</span> @php $registered += $row->registered; @endphp</td>
                      <td><span class="badge badge-danger px-2 py-1">{{ number_format($nr) }}</span> @php $notReg += $nr; @endphp</td>
                      <td>
                        <div class="progress mb-1" style="height:7px;border-radius:4px;">
                          <div class="progress-bar bg-success" style="width:{{ $pct }}%;"></div>
                        </div>
                        <small class="font-weight-bold">{{ $pct }}%</small>
                      </td>
                      <td><span class="badge badge-warning px-2 py-1">{{ number_format($row->attendance) }}</span> @php $totalAttendance += $row->attendance; @endphp   </td>
                    </tr>
                  @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No GP data found.</td></tr>
                  @endforelse
                </tbody>
                <tfoot class="font-weight-bold" style="background:#f8f9fa;">
                  <tr>
                    <td colspan="2" class="text-right">Total</td>
                    <td class="text-center">{{ number_format($total) }}</td>
                    <td class="text-center">{{ number_format($registered) }}</td>
                    <td class="text-center">{{ number_format($notReg) }}</td>
                    <td class="text-center">{{ $total > 0 ? round(($registered / $total) * 100, 1) : 0 }}%</td>
                    <td class="text-center">{{ number_format($totalAttendance) }}</td>
                  </tr>
                </tfoot>
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
