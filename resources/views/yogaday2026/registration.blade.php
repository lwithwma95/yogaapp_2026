@include('yogaday2026.layouts.header')

<style>
  body { padding-top: 70px; background: linear-gradient(160deg, #e8f5e9 0%, #f9fef9 60%, #e0f2f1 100%); min-height: 100vh; }

  /* ── Registration card ── */
  .reg-card {
    border: none;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 12px 40px rgba(0,0,0,0.10);
    background: #fff;
  }

  /* ── Card header ── */
  .reg-header {
    background: linear-gradient(135deg, #0d5c44, #198754, #20c997);
    padding: 28px 24px 24px;
    text-align: center;
    color: #fff;
  }
  .reg-header .yoga-emoji { font-size: 36px; margin-bottom: 8px; }
  .reg-header h2 { font-size: 1.6rem; font-weight: 700; margin-bottom: 4px; }
  .reg-header .member-name-tag {
    display: inline-block;
    background: rgba(255,255,255,0.18);
    border: 1px solid rgba(255,255,255,0.25);
    border-radius: 50px;
    padding: 4px 18px;
    font-size: 13px;
    font-weight: 600;
    margin-top: 8px;
    backdrop-filter: blur(6px);
  }

  /* ── Body ── */
  .reg-body { padding: 28px 24px; }
  @media (max-width: 576px) { .reg-body { padding: 20px 16px; } }

  /* ── Member info grid ── */
  .info-grid {
    background: #f0faf2;
    border: 1px solid #c3e6cb;
    border-radius: 16px;
    padding: 18px 20px;
    margin-bottom: 28px;
  }
  .info-grid-title {
    font-size: 12px; font-weight: 700; text-transform: uppercase;
    letter-spacing: .6px; color: #198754; margin-bottom: 14px;
  }
  .info-row {
    display: grid; grid-template-columns: 110px 1fr;
    gap: 6px 10px; font-size: 14px; margin-bottom: 10px;
  }
  .info-row:last-child { margin-bottom: 0; }
  .info-row .lbl { color: #6c757d; font-weight: 600; }
  .info-row .val { color: #1a3020; font-weight: 600; }

  /* ── Field label ── */
  .field-label {
    font-size: 13px; font-weight: 700; color: #333;
    text-transform: uppercase; letter-spacing: .4px;
    margin-bottom: 8px; display: block;
  }

  /* ── Mobile input ── */
  .mobile-input {
    height: 52px; border-radius: 14px !important;
    border: 1.5px solid #ced4da; font-size: 16px;
    padding-left: 16px; transition: border-color .2s;
  }
  .mobile-input:focus { border-color: #198754; box-shadow: 0 0 0 3px rgba(25,135,84,.12); }

  /* ── Photo upload zone ── */
  .photo-zone {
    border: 2px dashed #a8d5b5;
    border-radius: 18px;
    min-height: 120px;
    max-width: 260px;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    cursor: pointer;
    background: #f0faf2;
    transition: border-color .2s, background .2s;
    overflow: hidden;
    position: relative;
    margin: 0 auto;
  }
  .photo-zone:hover, .photo-zone.drag-over {
    border-color: #198754;
    background: #e2f5e8;
  }
  .photo-placeholder { text-align: center; padding: 16px; pointer-events: none; }
  .photo-placeholder .cam-icon { font-size: 32px; margin-bottom: 6px; }
  .photo-placeholder p { font-size: 13px; font-weight: 600; color: #198754; margin-bottom: 3px; }
  .photo-placeholder small { font-size: 11px; color: #6c757d; }
  .photo-preview {
    width: 100%; max-height: 200px;
    object-fit: cover; display: none;
    border-radius: 16px;
  }
  .photo-change-hint {
    position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%);
    background: rgba(0,0,0,.55); color: #fff;
    border-radius: 50px; padding: 4px 14px;
    font-size: 12px; font-weight: 600;
    white-space: nowrap; display: none;
  }
  .photo-zone.has-photo .photo-change-hint { display: block; }
  .photo-zone.has-photo .photo-placeholder { display: none; }
  .photo-zone.has-photo .photo-preview { display: block; }

  /* ── Submit button ── */
  .submit-btn {
    background: linear-gradient(135deg, #198754, #20c997);
    color: #fff; border: none;
    border-radius: 50px;
    padding: 14px 40px;
    font-size: 16px; font-weight: 700;
    width: 100%;
    box-shadow: 0 8px 24px rgba(25,135,84,.25);
    transition: opacity .2s, transform .15s;
  }
  .submit-btn:hover { opacity: .92; color: #fff; transform: translateY(-1px); }
  .submit-btn:disabled { opacity: .65; transform: none; cursor: not-allowed; }

  /* ── Already registered state ── */
  .already-reg-box {
    background: #d1e7dd; border: 1px solid #a3cfbb;
    border-radius: 16px; padding: 20px;
    text-align: center; color: #0a3622;
    font-weight: 600; font-size: 16px;
  }

  /* ── Back chip ── */
  .back-chip {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 13px; font-weight: 600; color: #198754;
    text-decoration: none; background: #e8f5e9;
    border: 1px solid #c3e6cb; border-radius: 50px;
    padding: 5px 14px; transition: .2s; margin-bottom: 16px;
  }
  .back-chip:hover { background: #198754; color: #fff; }
</style>

<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-7 col-md-9">

      {{-- Back --}}
      <a href="javascript:history.back()" class="back-chip">← Back to Members</a>

      <div class="reg-card">

        {{-- Header --}}
        <div class="reg-header">
          <div class="yoga-emoji">🧘</div>
          <h2>Yoga Session Registration</h2>
          <p style="opacity:.85;margin-bottom:4px">International Yoga Day 2026</p>
          <span class="member-name-tag">{{ $member->mem_name }}</span>
        </div>

        {{-- Body --}}
        <div class="reg-body">

        

          {{-- Member info ── ──────────────────────────────────────── --}}
          <div class="info-grid">
            <div class="info-grid-title">📋 Member Information</div>
            <div class="info-row">
              <span class="lbl">Name</span>
              <span class="val">{{ $member->mem_name }} <span class="text-muted fw-normal">({{ $member->mem_code }})</span></span>
            </div>
            <div class="info-row">
              <span class="lbl">SHG</span>
              <span class="val">{{ optional($member->shg)->shg_name }}</span>
            </div>
            <div class="info-row">
              <span class="lbl">Village</span>
              <span class="val">{{ optional($member->shg->village)->vill_name }}</span>
            </div>
            <div class="info-row">
              <span class="lbl">GP / VCDC</span>
              <span class="val">{{ optional(optional($member->shg->village)->gp)->gp_name }}</span>
            </div>
            <div class="info-row">
              <span class="lbl">Block</span>
              <span class="val">{{ optional(optional(optional($member->shg->village)->gp)->block)->block_name }}</span>
            </div>
            <div class="info-row">
              <span class="lbl">District</span>
              <span class="val">{{ optional(optional(optional(optional($member->shg->village)->gp)->block)->district)->district_name }}</span>
            </div>
          </div>

          @if($member->yoga2026_registration == 1)
            {{-- Already registered ── ─────────────────────────────── --}}
            <div class="already-reg-box">
              ✅ This member is already registered for Yoga Day 2026.
            </div>
          @else
            {{-- Registration form ── ─────────────────────────────── --}}
            <form method="POST" action="{{ route('yoga.registration.store') }}"
                  enctype="multipart/form-data" id="yogaForm">
              @csrf

              <input type="hidden" name="mem_no"   value="{{ $member->mem_no }}">
              <input type="hidden" name="mem_uid"  value="{{ $member->mem_uid }}">
              <input type="hidden" name="mem_name" value="{{ $member->mem_name }}">
              <input type="hidden" name="mem_code" value="{{ $member->mem_code }}">
              <input type="hidden" name="shg_code" value="{{ $member->shg_code }}">

              {{-- Mobile number ── ───────────────────────────────── --}}
              <div class="mb-4">
                <label class="field-label">📱 Mobile Number</label>
                <input type="tel" name="mobile" id="mobile"
                  class="form-control mobile-input"
                  maxlength="10"
                  value="{{ $member->mem_mobile }}"
                  placeholder="Enter 10-digit mobile number"
                  inputmode="numeric"
                  required>
                <div id="mobileError" class="text-danger mt-1" style="font-size:13px;"></div>
              </div>

              {{-- Photo upload ── ─────────────────────────────────── --}}
              <div class="mb-4">
                <label class="field-label">📸 Selfie Photo</label>
                <div class="photo-zone" id="photoZone"
                     onclick="document.getElementById('photo').click()"
                     ondragover="event.preventDefault();this.classList.add('drag-over')"
                     ondragleave="this.classList.remove('drag-over')"
                     ondrop="handleDrop(event)">
                  <div class="photo-placeholder">
                    <div class="cam-icon">📷</div>
                    <p>Tap to take a selfie or upload a photo</p>
                    <small>JPG, PNG or HEIC &nbsp;·&nbsp; Max 10 MB</small>
                  </div>
                  <img id="previewImage" class="photo-preview" alt="Preview">
                  <span class="photo-change-hint">Tap to change photo</span>
                </div>
                <input type="file" name="photo" id="photo"
                       accept="image/*"  required
                       class="d-none">
                <div id="faceError" class="text-danger mt-2" style="font-size:13px;text-align:center;"></div>
              </div>

              {{-- Submit ── ──────────────────────────────────────── --}}
              <button type="submit" class="btn submit-btn" id="submitBtn">
                ✅ Confirm Registration
              </button>

            </form>
          @endif

        </div>
      </div>

    </div>
  </div>
</div>

@include('yogaday2026.layouts.footer')

<script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/heic2any@0.0.4/dist/heic2any.min.js"></script>
<script>
  const WEIGHTS = 'https://cdn.jsdelivr.net/gh/justadudewhohacks/face-api.js@0.22.2/weights';
  let modelsReady = false;

  // Start loading model in background immediately
  faceapi.nets.tinyFaceDetector.loadFromUri(WEIGHTS)
    .then(() => { modelsReady = true; })
    .catch(() => { /* will use fallback compress */ });

  // ── Zone state helper ──────────────────────────────────────────
  function setZoneState(state, note) {
    const ph = document.querySelector('#photoZone .photo-placeholder');
    const states = {
      idle:        '<div class="cam-icon">📷</div><p>Tap to take a selfie or upload a photo</p><small>JPG, PNG or HEIC · Max 10 MB</small>',
      converting:  '<div class="cam-icon"><span class="spinner-border spinner-border-sm text-success"></span></div><p>Converting HEIC…</p><small>Please wait</small>',
      detecting:   '<div class="cam-icon"><span class="spinner-border spinner-border-sm text-success"></span></div><p>Detecting face…</p><small>Please wait</small>',
      compressing: '<div class="cam-icon"><span class="spinner-border spinner-border-sm text-success"></span></div><p>Compressing…</p><small>Please wait</small>',
      noface:      '<div class="cam-icon">😐</div><p style="color:#dc3545;margin:0">No face detected</p><small>Retake — face must be clearly visible</small>',
      ready:       '<div class="cam-icon">✅</div><p style="color:#198754;margin:0">Face captured!</p><small>' + (note || '') + '</small>',
      error:       '<div class="cam-icon">⚠️</div><p style="color:#dc3545;margin:0">Processing error</p><small>Please try again</small>',
    };
    ph.innerHTML = states[state] || states.idle;
  }

  function resetZone() {
    document.getElementById('photoZone').classList.remove('has-photo');
    document.getElementById('previewImage').src = '';
    document.getElementById('photo').value = '';
    setZoneState('idle');
  }

  function applyPreview(url) {
    document.getElementById('previewImage').src = url;
    document.getElementById('photoZone').classList.add('has-photo');
  }

  function isHeicFile(file) {
    const ext  = file.name.split('.').pop().toLowerCase();
    const mime = file.type.toLowerCase();
    return ext === 'heic' || ext === 'heif' || mime === 'image/heic' || mime === 'image/heif';
  }

  function loadImg(blob) {
    return new Promise((res, rej) => {
      const url = URL.createObjectURL(blob);
      const img = new Image();
      img.onload  = () => { URL.revokeObjectURL(url); res(img); };
      img.onerror = rej;
      img.src = url;
    });
  }

  async function cropFace(img) {
    const cvs = document.createElement('canvas');
    cvs.width  = img.naturalWidth;
    cvs.height = img.naturalHeight;
    cvs.getContext('2d').drawImage(img, 0, 0);

    const det = await faceapi.detectSingleFace(
      cvs,
      new faceapi.TinyFaceDetectorOptions({ inputSize: 320, scoreThreshold: 0.4 })
    );
    if (!det) return null;

    const { x, y, width: fw, height: fh } = det.box;
    const padX  = fw * 0.6;   // 60% sides
    const padYT = fh * 0.8;   // 80% above (forehead)
    const padYB = fh * 0.4;   // 40% below (chin)

    const sx = Math.max(0, Math.round(x - padX));
    const sy = Math.max(0, Math.round(y - padYT));
    const sw = Math.min(cvs.width  - sx, Math.round(fw + padX * 2));
    const sh = Math.min(cvs.height - sy, Math.round(fh + padYT + padYB));

    const out = document.createElement('canvas');
    out.width  = 400;
    out.height = Math.round(400 * sh / sw);
    out.getContext('2d').drawImage(cvs, sx, sy, sw, sh, 0, 0, out.width, out.height);
    return out;
  }

  async function compressCanvas(cvs, targetKB) {
    let q = 0.85, blob;
    do {
      blob = await new Promise(r => cvs.toBlob(r, 'image/jpeg', q));
      q = +(q - 0.1).toFixed(2);
    } while (blob && blob.size > targetKB * 1024 && q >= 0.3);
    return blob;
  }

  function injectFile(blob) {
    const f = new File([blob], 'selfie.jpg', { type: 'image/jpeg' });
    try {
      const dt = new DataTransfer();
      dt.items.add(f);
      document.getElementById('photo').files = dt.files;
    } catch (e) {
      window._fallbackBlob = blob;
    }
  }

  async function processFile(file) {
    document.getElementById('faceError').textContent = '';
    document.getElementById('photo').value = '';
    setZoneState('detecting');

    let jpgBlob = file;
    if (isHeicFile(file)) {
      setZoneState('converting');
      try { jpgBlob = await heic2any({ blob: file, toType: 'image/jpeg', quality: 0.9 }); }
      catch (e) { jpgBlob = file; }
    }

    const imgEl = await loadImg(jpgBlob).catch(() => null);
    if (!imgEl) { setZoneState('error'); return; }

    if (!modelsReady) {
      setZoneState('detecting');
      try {
        await faceapi.nets.tinyFaceDetector.loadFromUri(WEIGHTS);
        modelsReady = true;
      } catch (e) {
        await fallbackCompress(imgEl);
        return;
      }
    }

    setZoneState('detecting');
    const faceCvs = await cropFace(imgEl).catch(() => null);

    if (!faceCvs) {
      resetZone();
      setZoneState('noface');
      document.getElementById('faceError').textContent =
        'No face detected. Please take a clearer selfie with your face fully visible.';
      return;
    }

    setZoneState('compressing');
    const blob = await compressCanvas(faceCvs, 180);
    injectFile(blob);
    applyPreview(URL.createObjectURL(blob));
    setZoneState('ready', 'Face detected · ' + Math.round(blob.size / 1024) + ' KB');
  }

  async function fallbackCompress(imgEl) {
    const ratio = Math.min(1, 800 / Math.max(imgEl.naturalWidth, 1));
    const cvs   = document.createElement('canvas');
    cvs.width   = Math.round(imgEl.naturalWidth  * ratio);
    cvs.height  = Math.round(imgEl.naturalHeight * ratio);
    cvs.getContext('2d').drawImage(imgEl, 0, 0, cvs.width, cvs.height);
    const blob = await compressCanvas(cvs, 200);
    injectFile(blob);
    applyPreview(URL.createObjectURL(blob));
    setZoneState('ready', 'Photo compressed · ' + Math.round(blob.size / 1024) + ' KB');
  }

  function handleDrop(e) {
    e.preventDefault();
    document.getElementById('photoZone').classList.remove('drag-over');
    const file = e.dataTransfer.files[0];
    if (file) processFile(file);
  }

  document.getElementById('photo').addEventListener('change', function () {
    if (this.files[0]) processFile(this.files[0]);
  });

  // ── Validation + submit ────────────────────────────────────────
  document.getElementById('yogaForm')?.addEventListener('submit', function (e) {
    const mobile = document.getElementById('mobile').value;
    const errEl  = document.getElementById('mobileError');

    if (!/^[6-9]\d{9}$/.test(mobile)) {
      e.preventDefault();
      errEl.textContent = 'Enter a valid 10-digit Indian mobile number.';
      return;
    }
    errEl.textContent = '';

    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Uploading…';
  });

  document.getElementById('mobile')?.addEventListener('input', function () {
    document.getElementById('mobileError').textContent = '';
  });
</script>
