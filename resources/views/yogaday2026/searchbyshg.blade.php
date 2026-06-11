@include('yogaday2026.layouts.header')

<style>
  body { padding-top: 70px; background: #f4fbf6; }

  /* ── Card ── */
  .search-card {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
  }
  .search-card .card-header {
    background: linear-gradient(135deg, #198754, #20c997);
    padding: 20px 24px;
    border: none;
  }

  /* ── Search input group ── */
  .search-group .form-control {
    border-right: none;
    border-radius: 50px 0 0 50px !important;
    height: 52px;
    font-size: 15px;
    padding-left: 20px;
  }
  .search-group .form-control:focus { box-shadow: none; border-color: #198754; }
  .search-group .btn-search {
    border-radius: 0 50px 50px 0 !important;
    padding: 0 28px;
    font-weight: 700;
    font-size: 15px;
    background: #198754;
    border-color: #198754;
    color: #fff;
    height: 52px;
  }
  .search-group .btn-search:hover { background: #146c43; border-color: #146c43; }

  /* ── Results banner ── */
  .results-banner {
    background: #e8f5e9;
    border: 1px solid #c3e6cb;
    border-radius: 12px;
    padding: 12px 18px;
    font-size: 14px;
    font-weight: 600;
    color: #155724;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 16px;
  }
  .reg-badge {
    background: #198754; color: #fff;
    border-radius: 50px; padding: 3px 14px;
    font-size: 13px; font-weight: 700;
  }

  /* ── Member cards (mobile) ── */
  .member-card {
    display: flex; align-items: center; gap: 12px;
    border: 1px solid #dee2e6; border-radius: 12px;
    padding: 12px 14px; margin-bottom: 8px; background: #fff;
    transition: border-color .2s, background .2s;
  }
  .member-card:hover { border-color: #198754; background: #f6fef8; }
  .member-serial { min-width: 28px; font-weight: 700; font-size: 13px; color: #6c757d; text-align: center; }
  .member-info { flex: 1; min-width: 0; }
  .member-name { font-weight: 600; font-size: 15px; color: #212529; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
  .member-code { font-size: 12px; color: #6c757d; }

  /* ── Modal info grid ── */
  .modal-info-grid {
    display: grid; grid-template-columns: auto 1fr;
    gap: 8px 14px; font-size: 14px; text-align: left;
  }
  .modal-info-label { color: #6c757d; font-weight: 600; white-space: nowrap; }
  .modal-info-value { color: #212529; font-weight: 500; }

  /* ── Back link ── */
  .back-chip {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 13px; font-weight: 600; color: #198754;
    text-decoration: none; background: #e8f5e9;
    border: 1px solid #c3e6cb; border-radius: 50px;
    padding: 5px 14px; transition: .2s;
  }
  .back-chip:hover { background: #198754; color: #fff; }

  /* Responsive */
  @media (max-width: 767px) {
    .member-table-wrap { display: none !important; }
  }
  @media (min-width: 768px) {
    .member-cards-wrap { display: none !important; }
  }
</style>

<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-9">

      {{-- Back link --}}
      <div class="mb-3">
        <a href="{{ route('findmembers') }}" class="back-chip">
          ← Search by Location
        </a>
      </div>

      <div class="search-card card mb-4">

        {{-- Header --}}
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
          <div>
            <h5 class="mb-0 fw-bold text-white">🗂 Search by SHG Code</h5>
            <small class="text-white-50">Enter the SHG Code to find and register members</small>
          </div>
        </div>

        <div class="card-body p-4">

          {{-- Alerts --}}
          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              {{ session('success') }}
            </div>
          @endif
          @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show py-2">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              {{ session('error') }}
            </div>
          @endif

          {{-- Search form --}}
          <form method="POST" action="{{ route('yoga.findwithshgcode') }}">
            @csrf
            <label class="form-label fw-semibold mb-2 text-muted" style="font-size:13px;text-transform:uppercase;letter-spacing:.5px;">
              SHG Code
            </label>
            <div class="input-group search-group">
              <input type="text" name="shg_code"
                class="form-control"
                placeholder="e.g. 4001234567"
                value="{{ $shg_code ?? old('shg_code') }}"
                required autocomplete="off">
              <button type="submit" class="btn btn-search">
                🔍 Search
              </button>
            </div>
          </form>

          {{-- Results --}}
          @if(isset($members))
            <div class="mt-4">

              @if($members->isNotEmpty())
                @php
                  $regCount = $members->where('yoga2026_registration', 1)->count();
                @endphp
                <div class="results-banner">
                  <span>
                    📋 SHG Code: <strong>{{ $shg_code ?? '' }}</strong>
                    &nbsp;|&nbsp; {{ $members->count() }} members
                  </span>
                  <span class="reg-badge">✓ {{ $regCount }} Registered</span>
                </div>
              @endif

              {{-- Cards (mobile) --}}
              <div class="member-cards-wrap">
                @forelse($members as $member)
                  <div class="member-card">
                    <span class="member-serial">{{ $loop->iteration }}</span>
                    <div class="member-info">
                      <div class="member-name">{{ $member->mem_name }}</div>
                      <div class="member-code">{{ $member->mem_code }}</div>
                    </div>
                    <div class="flex-shrink-0">
                      @if($member->yoga2026_registration == 1)
                        <span class="badge bg-success px-3 py-2" style="border-radius:50px;font-size:12px;">🧘 Registered</span>
                      @else
                        <button type="button"
                          class="btn btn-primary btn-sm registerBtn fw-semibold"
                          data-memuid="{{ $member->mem_uid }}"
                          style="border-radius:50px;white-space:nowrap;">
                          Register Now
                        </button>
                      @endif
                    </div>
                  </div>
                @empty
                  <div class="text-center py-5 text-muted">
                    <div style="font-size:48px">🔍</div>
                    <p class="mt-2 fw-semibold">No members found for this SHG Code.</p>
                  </div>
                @endforelse
              </div>

              {{-- Table (desktop) --}}
              <div class="member-table-wrap table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                  <thead class="table-success">
                    <tr>
                      <th width="8%" class="text-center">Sl.No</th>
                      <th>Member Name</th>
                      <th width="20%" class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($members as $member)
                      <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>
                          {{ $member->mem_name }}
                          <br><small class="text-muted">{{ $member->mem_code }}</small>
                        </td>
                        <td class="text-center">
                          @if($member->yoga2026_registration == 1)
                            <span class="badge bg-success px-3 py-2" style="border-radius:50px;">🧘 Registered</span>
                          @else
                            <button type="button"
                              class="btn btn-primary btn-sm registerBtn fw-semibold"
                              data-memuid="{{ $member->mem_uid }}"
                              style="border-radius:50px;">
                              Register Now
                            </button>
                          @endif
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="3" class="text-center text-muted py-5">
                          🔍 No members found for this SHG Code.
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

            </div>
          @endif

        </div>
      </div>

    </div>
  </div>
</div>

{{-- Confirmation Modal (always in DOM) --}}
<div class="modal fade" id="yogaModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius:16px;overflow:hidden">
      <div class="modal-header" style="background:linear-gradient(135deg,#198754,#20c997);">
        <h5 class="modal-title fw-bold text-white">🧘 Confirm Yoga Registration</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="modal-info-grid">
          <span class="modal-info-label">Name</span>     <span class="modal-info-value" id="m_name"></span>
          <span class="modal-info-label">Code</span>     <span class="modal-info-value" id="m_code"></span>
          <span class="modal-info-label">SHG</span>      <span class="modal-info-value" id="m_shg"></span>
          <span class="modal-info-label">Guardian</span> <span class="modal-info-value" id="m_guardian"></span>
          <span class="modal-info-label">Village</span>  <span class="modal-info-value" id="m_village"></span>
          <span class="modal-info-label">GP/VCDC</span>  <span class="modal-info-value" id="m_gp"></span>
          <span class="modal-info-label">Block</span>    <span class="modal-info-value" id="m_block"></span>
          <span class="modal-info-label">District</span> <span class="modal-info-value" id="m_district"></span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <a href="#" class="btn btn-success btn-sm fw-bold" id="confirmBtn">✓ Confirm &amp; Register</a>
      </div>
    </div>
  </div>
</div>

@include('yogaday2026.layouts.footer')

<script>
$(function () {

  // ── Backdrop cleanup ────────────────────────────────────────────
  document.getElementById('yogaModal').addEventListener('hidden.bs.modal', function () {
    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    document.body.classList.remove('modal-open');
    document.body.style.removeProperty('padding-right');
  });

  // ── Register button — override footer's Bootstrap-4 handler ────
  $(document).off('click', '.registerBtn').on('click', '.registerBtn', function () {
    const uid = $(this).data('memuid');

    $.blockUI({
      message: '<div class="spinner-border text-light"></div>',
      css: { border: 'none', background: 'transparent' },
      overlayCSS: { backgroundColor: '#000', opacity: .5 }
    });

    $.get('/get-member-details/' + uid, function (m) {
      $('#m_name').text(m.mem_name);
      $('#m_code').text(m.mem_code);
      $('#m_shg').text(m.shg_name + ' (' + m.shg_code + ')');
      $('#m_guardian').text(m.guardian_name);
      $('#m_village').text(m.vill_name);
      $('#m_gp').text(m.gp_name);
      $('#m_block').text(m.block_name);
      $('#m_district').text(m.district_name);
      $('#confirmBtn').attr('href', '/yoga/registration/' + m.mem_uid);
      bootstrap.Modal.getOrCreateInstance(document.getElementById('yogaModal')).show();
    })
    .fail(function () {
      Swal.fire({ icon: 'error', title: 'Error', text: 'Unable to load member details.' });
    })
    .always(function () { $.unblockUI(); });
  });

});
</script>
