<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Block Dashboard</title>
  @include('block.includes.header')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  @include('block.includes.navbar')
  @include('block.includes.sidebar')

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Block Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('block.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">

        {{-- BLOCK TITLE BANNER --}}
        @if($block)
        <div class="card mb-3" style="border:none;border-radius:12px;background:linear-gradient(135deg,#155724,#1a6b2e,#28a745);color:#fff;">
          <div class="card-body py-3 px-4">
            <div class="d-flex align-items-center">
              <i class="fas fa-map-marked-alt fa-2x mr-3" style="opacity:.85"></i>
              <div>
                <div style="font-size:11px;opacity:.75;text-transform:uppercase;letter-spacing:.6px;">Block</div>
                <div style="font-size:1.4rem;font-weight:800;">{{ $block->block_name }}</div>
              </div>
            </div>
          </div>
        </div>
        @endif

        

      
      </div>
    </section>
  </div>

  @include('block.includes.footer')
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
