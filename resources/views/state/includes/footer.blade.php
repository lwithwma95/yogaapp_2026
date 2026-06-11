  <!-- Main Footer -->
  <footer class="main-footer" style="background: #f8fdf9; border-top: 2px solid #14532d; padding: 8px 20px;">
    <div class="d-flex align-items-center justify-content-center">
      @if(file_exists(public_path('assets/images/assam_emblem.png')))
        <img src="{{ asset('assets/images/assam_emblem.png') }}" alt="Assam Govt"
          style="height: 28px; margin-right: 8px; opacity: .92;">
      @else
        <img src="{{ asset('assets/images/logo.png') }}" alt="ASRLM"
          style="height: 28px; margin-right: 8px; opacity: .92;">
      @endif
      <div style="line-height: 1.3;">
        <strong style="color: #14532d; font-size: 0.82rem; letter-spacing: 0.2px;">ASRLM</strong>
        <span style="font-size: 0.7rem; color: #9ca3af; margin-left: 8px;">&copy; {{ date('Y') }}</span>
      </div>
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('assets/dist/js/adminlte.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
