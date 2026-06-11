<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>State Dashboard</title>
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
            <h1 class="m-0">State Dashboard — Assam</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('state.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">

        {{-- SYNC FLASH MESSAGE --}}
        @if(session('sync_success'))
          <div class="alert alert-success alert-dismissible fade show shadow-sm" style="border-radius:10px;border-left:4px solid #28a745;" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ session('sync_success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
          </div>
        @endif

        {{-- STATE BANNER --}}
        <div class="card mb-3" style="border:none;border-radius:12px;background:linear-gradient(135deg,#155724,#1a6b2e,#28a745);color:#fff;">
          <div class="card-body py-3 px-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap:12px;">
              <div class="d-flex align-items-center">
                <i class="fas fa-globe-asia fa-2x mr-3" style="opacity:.85"></i>
                <div>
                  <div style="font-size:11px;opacity:.75;text-transform:uppercase;letter-spacing:.6px;">International Yoga Day 2026</div>
                  <div style="font-size:1.4rem;font-weight:800;">Assam State Overview</div>
                </div>
              </div>
              <div class="d-flex flex-wrap" style="gap:8px;">
                
                
              </div>
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
  $('#districtTable').DataTable({
    responsive: true,
    pageLength: 35,
    dom: 'Bfrtip',
    buttons: [
      { extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-success btn-sm', title: 'State_District_Report' },
      { extend: 'print', text: '<i class="fas fa-print"></i> Print', className: 'btn btn-primary btn-sm' }
    ],
    order: [[1, 'asc']]
  });
});
</script>
</body>
</html>
