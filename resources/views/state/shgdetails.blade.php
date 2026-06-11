<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SHG Members — {{ $shg->shg_name }}</title>
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
              <h1 class="m-0">{{ $shg->shg_name }}</h1>
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

          {{-- SHG INFO CARD --}}
          <div class="card mb-3"
            style="border:none;border-radius:12px;background:linear-gradient(135deg,#155724,#1a6b2e,#28a745);color:#fff;">
            <div class="card-body py-3 px-4">
              <div class="d-flex align-items-center flex-wrap" style="gap:20px;">
                <div>
                  <div style="font-size:10px;opacity:.7;text-transform:uppercase;letter-spacing:.5px;">SHG Code</div>
                  <div style="font-size:1rem;font-weight:700;">{{ $shg->shg_code }}</div>
                </div>
                <div>
                  <div style="font-size:10px;opacity:.7;text-transform:uppercase;letter-spacing:.5px;">SHG Name</div>
                  <div style="font-size:1rem;font-weight:700;">{{ $shg->shg_name }}</div>
                </div>
                <div>
                  <div style="font-size:10px;opacity:.7;text-transform:uppercase;letter-spacing:.5px;">Village</div>
                  <div style="font-size:1rem;font-weight:700;">{{ $shg->village->vill_name }}</div>
                </div>
                <div>
                  <div style="font-size:10px;opacity:.7;text-transform:uppercase;letter-spacing:.5px;">GP</div>
                  <div style="font-size:1rem;font-weight:700;">{{ $shg->village->gp->gp_name }}</div>
                </div>
              </div>
            </div>
          </div>


          {{-- MEMBER TABLE --}}
          <div class="card shadow-sm" style="border:none;border-radius:12px;overflow:hidden;">
            <div class="card-header"
              style="background:linear-gradient(135deg,#1e3a5f,#1565a0,#1e88c8);color:#fff;padding:14px 20px;">
              <h5 class="mb-0" style="font-size:15px;font-weight:700;">
                <i class="fas fa-id-card mr-2"></i>
                Member List — {{ $shg->shg_name }}
              </h5>
            </div>

            <div class="card-body p-0">
              <div class="table-responsive">

                <table id="memberTable" class="table table-bordered table-hover mb-0" style="font-size:13px;">

                  <thead class="text-center" style="background:#f0f4f8;">
                    <tr>
                      <th width="5%">#</th>
                      <th width="8%">Photo</th>
                      <th class="text-left">Member Name</th>
                      <th width="15%">Member Code</th>
                      <th width="13%">Registration</th>
                      <th width="13%">Attendance</th>
                    </tr>
                  </thead>

                  <tbody>
                    @forelse($members as $member)

                      @php
                        $photoUrl = $member->yoga_selfie
                          ? Storage::disk('s3')->temporaryUrl($member->yoga_selfie, now()->addMinutes(30))
                          : null;
                      @endphp

                      <tr class="text-center">

                        <td class="text-muted">{{ $loop->iteration }}</td>

                        {{-- PHOTO --}}
                        <td>
                          @if($photoUrl)
                            <img src="{{ $photoUrl }}" alt="Photo"
                              style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
                          @else
                            <img src="{{ asset('assets/images/no-image.png') }}" alt="No Photo"
                              style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
                          @endif
                        </td>

                        <td class="text-left font-weight-bold">
                          {{ $member->mem_name }}
                        </td>

                        <td>
                          <small class="text-muted">{{ $member->mem_code }}</small>
                        </td>

                        <td>
                          @if($member->yoga2026_registration == 1)
                            <span class="badge badge-success px-2 py-1">
                              <i class="fas fa-check mr-1"></i>Registered
                            </span>
                          @else
                            <span class="badge badge-danger px-2 py-1">
                              <i class="fas fa-times mr-1"></i>Not Registered
                            </span>
                          @endif
                        </td>

                        <td>
                          @if($member->yoga_attendance == 1)
                            <span class="badge badge-success px-2 py-1">
                              <i class="fas fa-running mr-1"></i>Present
                            </span>
                          @else
                            <span class="badge badge-secondary px-2 py-1">
                              <i class="fas fa-minus mr-1"></i>Absent
                            </span>
                          @endif
                        </td>

                      </tr>

                    @empty
                      <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                          No members found.
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

    @include('state.includes.footer')
  </div>

  <script>
    $(function () {
      $('#memberTable').DataTable({
        responsive: true,
        pageLength: 25,
        dom: 'Bfrtip',
        buttons: [
          { extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-success btn-sm', title: 'SHG_Member_Attendance' },
          { extend: 'print', text: '<i class="fas fa-print"></i> Print', className: 'btn btn-primary btn-sm' }
        ],
        order: [[1, 'asc']]
      });
    });
  </script>
</body>

</html>