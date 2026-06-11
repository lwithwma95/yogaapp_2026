@include('yogaday2026.layouts.header')

<style>
  body { padding-top: 70px; background: #f4fbf6; }

  /* ── Page card ── */
  .find-card {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    background: #fff;
  }
  .find-card .card-header {
    background: linear-gradient(135deg,#198754,#20c997);
    color: #fff;
    padding: 18px 24px;
    border: none;
  }

  /* ── Step indicator ── */
  .stepper {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0;
    padding: 18px 16px 10px;
    overflow-x: auto;
    flex-wrap: nowrap;
    scrollbar-width: none;
  }
  .stepper::-webkit-scrollbar { display: none; }
  .step {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 52px;
    position: relative;
    flex: 1;
  }
  .step:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 16px;
    left: calc(50% + 16px);
    right: calc(-50% + 16px);
    height: 2px;
    background: #dee2e6;
    z-index: 0;
    transition: background .3s;
  }
  .step.done:not(:last-child)::after { background: #198754; }
  .step-circle {
    width: 32px; height: 32px;
    border-radius: 50%;
    border: 2px solid #dee2e6;
    background: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 700; color: #adb5bd;
    position: relative; z-index: 1;
    transition: all .3s;
  }
  .step.active .step-circle {
    border-color: #198754; color: #198754; background: #e8f5e9;
  }
  .step.done .step-circle {
    border-color: #198754; background: #198754; color: #fff;
  }
  .step-label {
    font-size: 10px; color: #adb5bd; margin-top: 4px;
    font-weight: 600; text-align: center; white-space: nowrap;
  }
  .step.active .step-label,
  .step.done  .step-label { color: #198754; }

  /* ── Dropdowns ── */
  .filter-section { padding: 8px 20px 20px; }
  .filter-row { display: flex; flex-wrap: wrap; gap: 14px; }
  .filter-group { flex: 1 1 160px; min-width: 0; }
  .filter-label {
    font-size: 12px; font-weight: 700; color: #495057;
    text-transform: uppercase; letter-spacing: .5px;
    margin-bottom: 5px; display: flex; align-items: center; gap: 5px;
  }
  .filter-label .done-tick { color: #198754; display: none; }
  .filter-group.done .filter-label .done-tick { display: inline; }
  .filter-group.done .form-select { border-color: #198754; }

  /* ── Member results ── */
  .results-banner {
    background: #e8f5e9; border: 1px solid #c3e6cb;
    border-radius: 10px; padding: 10px 16px;
    font-size: 14px; font-weight: 600; color: #155724;
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 6px; margin-bottom: 14px;
  }

  /* Cards (mobile default) */
  .member-card {
    display: flex; align-items: center; gap: 12px;
    border: 1px solid #dee2e6; border-radius: 12px;
    padding: 12px 14px; margin-bottom: 8px; background: #fff;
    transition: border-color .2s, background .2s;
  }
  .member-card:hover { border-color: #198754; background: #f6fef8; }
  .member-serial {
    min-width: 28px; font-weight: 700; font-size: 13px; color: #6c757d;
    text-align: center;
  }
  .member-info { flex: 1; min-width: 0; }
  .member-name {
    font-weight: 600; font-size: 15px; color: #212529;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
  }
  .member-code { font-size: 12px; color: #6c757d; }

  /* Table (desktop) */
  @media (min-width: 768px) {
    .member-card { display: none; }
    .member-table-wrap { display: block !important; }
  }
  @media (max-width: 767px) {
    .member-table-wrap { display: none !important; }
    .member-card { display: flex; }
  }

  /* ── Modal info grid ── */
  .modal-info-grid {
    display: grid; grid-template-columns: auto 1fr; gap: 6px 12px;
    font-size: 14px; text-align: left;
  }
  .modal-info-label { color: #6c757d; font-weight: 600; white-space: nowrap; }
  .modal-info-value { color: #212529; font-weight: 500; }

  /* Search by SHG chip */
  .shg-chip {
    background: #fff3cd; color: #856404; border: 1px solid #ffc107;
    border-radius: 50px; padding: 6px 16px; font-size: 13px; font-weight: 700;
    text-decoration: none; transition: .2s;
  }
  .shg-chip:hover { background: #ffc107; color: #000; }

  /* Placeholder */
  .search-placeholder {
    text-align: center; padding: 40px 20px; color: #adb5bd;
  }
</style>

<div class="container py-4">

  <div class="find-card mb-4">

    {{-- Header --}}
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div>
        <h5 class="mb-0 fw-bold">🔍 SHG Member Search</h5>
        <small style="opacity:.85">Select location to find and register members</small>
      </div>
      <a href="{{ route('searchbyshg') }}" class="shg-chip">
        🗂 Search by SHG Code
      </a>
    </div>

    {{-- Step indicator --}}
    <div class="stepper" id="stepper">
      <div class="step active" id="step-district">
        <div class="step-circle">1</div>
        <span class="step-label">District</span>
      </div>
      <div class="step" id="step-block">
        <div class="step-circle">2</div>
        <span class="step-label">Block</span>
      </div>
      <div class="step" id="step-gp">
        <div class="step-circle">3</div>
        <span class="step-label">GP/VCDC</span>
      </div>
      <div class="step" id="step-village">
        <div class="step-circle">4</div>
        <span class="step-label">Village</span>
      </div>
      <div class="step" id="step-shg">
        <div class="step-circle">5</div>
        <span class="step-label">SHG</span>
      </div>
    </div>

    {{-- Filters --}}
    <div class="filter-section">
      <div class="filter-row">

        {{-- District --}}
        <div class="filter-group" id="fg-district">
          <div class="filter-label">
            <span>District  (জিলা)</span>
            <span class="done-tick">✓</span>
          </div>
          <select id="district" name="district_id" class="form-select">
            <option value="">-- Select District --</option>
            @foreach($districts as $d)
              <option value="{{ $d->district_id }}">{{ $d->district_name }}</option>
            @endforeach
          </select>
        </div>

        {{-- Block --}}
        <div class="filter-group" id="fg-block">
          <div class="filter-label">
            <span>Block (খণ্ড)</span>
            <span class="done-tick">✓</span>
          </div>
          <select id="block" name="block_id" class="form-select" disabled>
            <option value="">-- Select Block --</option>
          </select>
        </div>

        {{-- GP --}}
        <div class="filter-group" id="fg-gp">
          <div class="filter-label">
            <span>GP / VCDC (গ্ৰাম পঞ্চায়ত/ভিচিডিচি)</span>
            <span class="done-tick">✓</span>
          </div>
          <select id="gp" name="gp_id" class="form-select" disabled>
            <option value="">-- Select GP --</option>
          </select>
        </div>

        {{-- Village --}}
        <div class="filter-group" id="fg-village">
          <div class="filter-label">
            <span>Village (গাওঁ)</span>
            <span class="done-tick">✓</span>
          </div>
          <select id="village" name="vill_id" class="form-select" disabled>
            <option value="">-- Select Village --</option>
          </select>
        </div>

        {{-- SHG --}}
        <div class="filter-group w-100" id="fg-shg">
          <div class="filter-label">
            <span>SHG (আত্মসহায়ক গোট) </span>
            <span class="done-tick">✓</span>
          </div>
          <select id="shg" name="shg_code" class="form-select select2" disabled>
            <option value="">-- Select SHG --</option>
          </select>
        </div>

      </div>
    </div>
  </div>

  {{-- Member Results --}}
  <div id="memberSection">
    <div class="search-placeholder" id="searchPlaceholder">
      <div style="font-size:48px">🧘</div>
      <p class="mt-2 mb-0 fw-semibold" style="color:#6c757d">
        Select a location above to find members
      </p>
    </div>
  </div>

</div>

{{-- Confirmation Modal --}}
<div class="modal fade" id="yogaModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">🧘 Confirm Yoga Registration</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="modal-info-grid">
          <span class="modal-info-label">Name</span>       <span class="modal-info-value" id="m_name"></span>
          <span class="modal-info-label">Code</span>       <span class="modal-info-value" id="m_code"></span>
          <span class="modal-info-label">SHG</span>        <span class="modal-info-value" id="m_shg"></span>
          <span class="modal-info-label">Guardian</span>   <span class="modal-info-value" id="m_guardian"></span>
          <span class="modal-info-label">Village</span>    <span class="modal-info-value" id="m_village"></span>
          <span class="modal-info-label">GP / VCDC</span>  <span class="modal-info-value" id="m_gp"></span>
          <span class="modal-info-label">Block</span>      <span class="modal-info-value" id="m_block"></span>
          <span class="modal-info-label">District</span>   <span class="modal-info-value" id="m_district"></span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <a href="#" class="btn btn-success btn-sm fw-bold" id="confirmBtn">
          ✓ Confirm &amp; Register
        </a>
      </div>
    </div>
  </div>
</div>

@include('yogaday2026.layouts.footer')
<script>
  function getCachedData(key) {
    const cached = localStorage.getItem(key);

    if (!cached) {
        return null;
    }

    try {
        const parsed = JSON.parse(cached);

        if (Date.now() > parsed.expiry) {
            localStorage.removeItem(key);
            return null;
        }

        return parsed.data;
    } catch (e) {
        localStorage.removeItem(key);
        return null;
    }
}

function setCachedData(key, data, hours = 24) {
    localStorage.setItem(key, JSON.stringify({
        data: data,
        expiry: Date.now() + (hours * 60 * 60 * 1000)
    }));
}
$(function () {

  // ── Stepper helpers ────────────────────────────────────────────
  function stepDone(id) {
    const el = document.getElementById('step-' + id);
    if (!el) return;
    el.classList.remove('active');
    el.classList.add('done');
    el.querySelector('.step-circle').innerHTML = '✓';
  }
  function stepActive(id) {
    const el = document.getElementById('step-' + id);
    if (!el) return;
    el.classList.add('active');
    el.classList.remove('done');
  }
  function stepReset(id) {
    const el = document.getElementById('step-' + id);
    if (!el) return;
    const num = {'district':1,'block':2,'gp':3,'village':4,'shg':5}[id];
    el.classList.remove('active','done');
    el.querySelector('.step-circle').innerHTML = num;
  }
  function filterDone(id, done) {
    document.getElementById('fg-' + id)?.classList.toggle('done', done);
  }

  function clearFrom(level) {
    // Reset all steps and groups from the given level downward
    const order = ['block','gp','village','shg'];
    const idx   = order.indexOf(level);
    for (let i = idx; i < order.length; i++) {
      stepReset(order[i]);
      filterDone(order[i], false);
      $('#' + order[i]).html('<option value="">-- Select ' + order[i].toUpperCase() + ' --</option>').prop('disabled', true);
    }
    $('#memberSection').html('<div class="search-placeholder" id="searchPlaceholder"><div style="font-size:48px">🧘</div><p class="mt-2 mb-0 fw-semibold" style="color:#6c757d">Select a location above to find members</p></div>');
  }

  // ── Select2 ───────────────────────────────────────────────────
  function initSelect2(sel) {
    $(sel).select2({ theme: 'bootstrap-5', width: '100%', allowClear: true });
  }
  initSelect2('#shg');

  // ── District → Block ──────────────────────────────────────────
  // .off() removes the footer's generic handler so we don't double-fire
 $('#district').off('change').on('change', function () {

    const val = $(this).val();

    clearFrom('block');

    if (!val) {
        stepReset('district');
        filterDone('district', false);
        return;
    }

    stepDone('district');
    filterDone('district', true);
    stepActive('block');

    $('#block')
        .html('<option value="">Loading...</option>')
        .prop('disabled', true);

    const cacheKey = 'blocks_' + val;
    const cached = getCachedData(cacheKey);

    if (cached) {
        populateBlocks(cached);
        return;
    }

    $.get('/get-blocks/' + val, function (data) {

        setCachedData(cacheKey, data);

        populateBlocks(data);

    });

    function populateBlocks(data) {

        let opts = '<option value="">-- Select Block --</option>';

        $.each(data, function (i, item) {
            opts += `<option value="${item.block_id}">${item.block_name}</option>`;
        });

        $('#block')
            .html(opts)
            .prop('disabled', false);
    }

});

$('#block').off('change').on('change', function () {

    const val = $(this).val();

    clearFrom('gp');

    if (!val) {
        stepReset('block');
        stepActive('block');
        filterDone('block', false);
        return;
    }

    stepDone('block');
    filterDone('block', true);
    stepActive('gp');

    $('#gp')
        .html('<option value="">Loading...</option>')
        .prop('disabled', true);

    const cacheKey = 'gps_' + val;
    const cached = getCachedData(cacheKey);

    if (cached) {
        populateGps(cached);
        return;
    }

    $.get('/get-gps/' + val, function (data) {

        setCachedData(cacheKey, data);

        populateGps(data);

    });

    function populateGps(data) {

        let opts = '<option value="">-- Select GP --</option>';

        $.each(data, function (i, item) {
            opts += `<option value="${item.gp_id}">${item.gp_name}</option>`;
        });

        $('#gp')
            .html(opts)
            .prop('disabled', false);
    }

});

  // ── GP → Village ──────────────────────────────────────────────
  $('#gp').off('change').on('change', function () {

    const val = $(this).val();

    clearFrom('village');

    if (!val) {
        stepReset('gp');
        stepActive('gp');
        filterDone('gp', false);
        return;
    }

    stepDone('gp');
    filterDone('gp', true);
    stepActive('village');

    $('#village')
        .html('<option value="">Loading...</option>')
        .prop('disabled', true);

    const cacheKey = 'villages_' + val;
    const cached = getCachedData(cacheKey);

    if (cached) {
        populateVillages(cached);
        return;
    }

    $.get('/get-villages/' + val, function (data) {

        setCachedData(cacheKey, data);

        populateVillages(data);

    });

    function populateVillages(data) {

        let opts = '<option value="">-- Select Village --</option>';

        $.each(data, function (i, item) {
            opts += `<option value="${item.vill_id}">${item.vill_name}</option>`;
        });

        $('#village')
            .html(opts)
            .prop('disabled', false);
    }

});

  // ── Village → SHG ─────────────────────────────────────────────
$('#village').off('change').on('change', function () {

    const val = $(this).val();

    clearFrom('shg');

    if (!val) {
        stepReset('village');
        stepActive('village');
        filterDone('village', false);
        return;
    }

    stepDone('village');
    filterDone('village', true);
    stepActive('shg');

    $('#shg')
        .html('<option value="">Loading...</option>')
        .prop('disabled', true);

    const cacheKey = 'shgs_' + val;
    const cached = getCachedData(cacheKey);

    if (cached) {
        populateShgs(cached);
        return;
    }

    $.get('/get-shgs/' + val, function (data) {

        setCachedData(cacheKey, data);

        populateShgs(data);

    });

    function populateShgs(data) {

        let opts = '<option value="">-- Select SHG --</option>';

        $.each(data, function (i, item) {

            opts += `
                <option value="${item.shg_code}">
                    ${item.shg_name} (${item.shg_code})
                </option>
            `;
        });

        $('#shg')
            .html(opts)
            .prop('disabled', false);

        $('#shg').select2('destroy');
        initSelect2('#shg');
    }

});

  // ── SHG → Members ─────────────────────────────────────────────
  $(document).on('change', '#shg', function () {
    const val  = $(this).val();
    const name = $(this).find('option:selected').text();
    if (!val) { stepReset('shg'); stepActive('shg'); filterDone('shg', false); return; }
    stepDone('shg'); filterDone('shg', true);

    $('#memberSection').html('<div class="text-center py-5"><div class="spinner-border text-success"></div><p class="mt-2 text-muted">Loading members…</p></div>');

    $.get('/get-members/' + encodeURIComponent(val), function (data) {
      if (!data || data.length === 0) {
        $('#memberSection').html('<div class="alert alert-warning">No members found for this SHG.</div>');
        return;
      }

      const reg   = data.filter(m => m.yoga2026_registration == 1).length;
      const total = data.length;

      let cards = '', rows = '';
      $.each(data, function (i, m) {
        const isReg  = m.yoga2026_registration == 1;
        const badge  = isReg
          ? `<span class="badge bg-success px-3 py-2" style="border-radius:50px;font-size:12px;">🧘 Registered</span>`
          : `<a href="/yoga/registration/${m.mem_uid}"
                type="button"
                class="btn btn-primary btn-sm  fw-semibold"
                style="border-radius:50px;white-space:nowrap;"
                onclick="return confirm('Are you sure you want to register for Yoga Sangam 2026?');">
                Register Now
            </a>`;

        // Card (mobile)
        cards += `
          <div class="member-card">
            <span class="member-serial">${i+1}</span>
            <div class="member-info">
              <div class="member-name">${m.mem_name}</div>
              <div class="member-code">${m.mem_code}</div>
            </div>
            <div class="flex-shrink-0">${badge}</div>
          </div>`;

        // Table row (desktop)
        rows += `
          <tr>
            <td class="text-center">${i+1}</td>
            <td>${m.mem_name}<br><small class="text-muted">${m.mem_code}</small></td>
            <td>${m.guardian_name}</td>
            <td class="text-center">${badge}</td>
          </tr>`;
      });

      $('#memberSection').html(`
        <div class="results-banner">
          <span>📋 <strong>${name.split('(')[0].trim()}</strong></span>
          <span>${total} members &nbsp;|&nbsp; <span class="text-success fw-bold">${reg} registered</span></span>
        </div>

        {{-- Cards: shown on mobile --}}
        <div class="d-md-none">${cards}</div>

        {{-- Table: shown on desktop --}}
        <div class="d-none d-md-block member-table-wrap">
          <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
              <thead class="table-success">
                <tr>
                  <th width="8%" class="text-center">Sl.No</th>
                  <th>Member Name</th>
                  <th>Guardian Name</th>
                  <th width="18%" class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>${rows}</tbody>
            </table>
          </div>
        </div>
      `);
    }).fail(function () {
      $('#memberSection').html('<div class="alert alert-danger">Failed to load members. Please try again.</div>');
    });
  });

  // ── Modal cleanup — prevent stuck backdrop after Cancel / close ──
  document.getElementById('yogaModal').addEventListener('hidden.bs.modal', function () {
    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    document.body.classList.remove('modal-open');
    document.body.style.removeProperty('padding-right');
  });

  // ── Register button → Modal ────────────────────────────────────
  $(document).on('click', '.registerBtn', function () {
    const uid = $(this).data('memuid');
    $.blockUI({ message: '<div class="spinner-border text-light"></div>', css: { border: 'none', background: 'transparent' }, overlayCSS: { backgroundColor: '#000', opacity: .5 } });
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
    }).fail(function () {
      Swal.fire({ icon: 'error', title: 'Error', text: 'Unable to load member details.' });
    }).always(function () { $.unblockUI(); });
  });

});
</script>
