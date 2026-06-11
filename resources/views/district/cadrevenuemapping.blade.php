<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cadre Venue Mapping — {{ optional($district)->district_name }}</title>
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
              <h1 class="m-0">Cadre Venue Mapping — Block-wise</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('district.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Cadre Venue Mapping</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">



          {{-- BLOCK TABLE --}}
          <div class="card shadow-sm" style="border:none;border-radius:12px;overflow:hidden;">
            <div class="card-header"
              style="background:linear-gradient(135deg,#1e3a5f,#1565a0,#1e88c8);color:#fff;padding:14px 20px;">
              <h5 class="mb-0" style="font-size:15px;font-weight:700;">
                <i class="fas fa-building mr-2"></i>Select a Block to view GP/VCDC-wise details
              </h5>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table id="blockTable" class="table table-bordered table-hover mb-0" style="font-size:13px;">
                  <thead class="text-center" style="background:#f0f4f8;">
                    <tr>
                      <th width="5%">#</th>
                      <th class="text-left">Block Name</th>
                      <th width="10%">Total Venues</th>
                      <th width="12%">SHG Mapped</th>
                      <th width="11%">Yoga Photo Uploaded</th>
                      <th width="10%">Not Uploaded</th>

                      <th width="14%">% Uploaded</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($rows as $row)
                      @php
                        $notUp = $row->total_venues - $row->photo_uploaded;
                        $pct = $row->total_venues > 0 ? round(($row->photo_uploaded / $row->total_venues) * 100, 1) : 0;
                      @endphp
                      <tr class="text-center">
                        <td class="text-muted">{{ $loop->iteration }}</td>
                        <td class="text-left font-weight-bold">
                          <a href="{{ route('district.cvm.block', $row->block_id) }}" class="text-primary">
                            <i class="fas fa-arrow-right mr-1" style="font-size:10px;"></i>{{ $row->block_name }}
                          </a>
                        </td>
                        <td><span class="badge badge-primary px-2 py-1">{{ number_format($row->total_venues) }}</span>
                        </td>
                        <td><span class="badge badge-info px-2 py-1">{{ number_format($row->total_shg) }}</span></td>
                        <td><span class="badge badge-success px-2 py-1">{{ number_format($row->photo_uploaded) }}</span>
                        </td>
                        <td><span class="badge badge-danger px-2 py-1">{{ number_format($notUp) }}</span></td>

                        <td>
                          <div class="progress mb-1" style="height:7px;border-radius:4px;">
                            <div class="progress-bar bg-success" style="width:{{ $pct }}%;"></div>
                          </div>
                          <small class="font-weight-bold">{{ $pct }}%</small>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="8" class="text-center text-muted py-4">No blocks found.</td>
                      </tr>
                    @endforelse
                  </tbody>
                  @php
                    $totalVenues = $rows->sum('total_venues');
                    $totalShgs = $rows->sum('total_shg');
                    $totalUploaded = $rows->sum('photo_uploaded');
                    $totalNotUploaded = $totalVenues - $totalUploaded;

                    $overallPct = $totalVenues > 0
                      ? round(($totalUploaded / $totalVenues) * 100, 1)
                      : 0;
                  @endphp
                  <tfoot style="background:#f8f9fa;font-weight:700;">
                    <tr class="text-center">
                      <td colspan="2" class="text-right">
                        <strong>Grand Total</strong>
                      </td>

                      <td class="text-center">
                          {{ number_format($totalVenues) }}
                      </td>

                      <td class="text-center">
                          {{ number_format($totalShgs) }}
                      </td>

                      <td class="text-center">
                          {{ number_format($totalUploaded) }}
                      </td>

                      <td class="text-center">
                          {{ number_format($totalNotUploaded) }}
                      </td>

                      <td class="text-center">
                        <div class="progress mb-1" style="height:7px;border-radius:4px;">
                          <div class="progress-bar bg-success" style="width:{{ $overallPct }}%;">
                          </div>
                        </div>
                        <small class="font-weight-bold">
                          {{ $overallPct }}%
                        </small>
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

    @include('district.includes.footer')
  </div>

  <script>
    $(function () {
      $('#blockTable').DataTable({
        responsive: true, pageLength: 25,
        dom: 'Bfrtip',
        buttons: [
          { extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-success btn-sm', title: 'District_CVM_Block' },
          { extend: 'print', text: '<i class="fas fa-print"></i> Print', className: 'btn btn-primary btn-sm' }
        ],
        order: [[1, 'asc']]
      });
    });
  </script>
</body>

</html>