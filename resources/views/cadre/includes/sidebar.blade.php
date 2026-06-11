<aside class="main-sidebar sidebar-dark-success elevation-4"
  style="background:linear-gradient(180deg,#1a3c2e 0%,#14532d 100%);">

  <a href="{{ route('cadre.dashboard') }}" class="brand-link"
    style="border-bottom:1px solid rgba(255,255,255,0.1);padding:10px 14px;background:transparent;">
    <img src="{{ asset('assets/images/assam_govt.svg') }}" alt="Assam Govt Logo"
      class="brand-image img-circle elevation-3"
      style="width:33px;height:33px;background:#fff;border-radius:50%;padding:2px;opacity:1;">
    <strong style="color:#f0fdf4;">IYD Assam</strong>
  </a>

  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="border-bottom:1px solid rgba(255,255,255,0.08);">
      <div class="image">
        <img src="{{ asset('assets/images/asrlm_logo.png') }}" class="img-circle elevation-2" alt="User">
      </div>
      <div class="info">
        <a href="#" class="d-block" style="color:#f0fdf4;font-size:0.88rem;">
          {{ $memberName ?? auth()->user()->name }}
        </a>
        <span style="font-size:0.72rem;color:#86efac;">Yoga Cadre</span>
      </div>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item">
          <a href="{{ route('cadre.dashboard') }}"
            class="nav-link {{ request()->routeIs('cadre.dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-home" style="color:#fbbf24;"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('cadre.shgmembers') }}"
            class="nav-link {{ request()->routeIs('cadre.shgmembers') ? 'active' : '' }}">
            <i class="far fa-user nav-icon" style="color:#fbbf24;"></i>
            <p>View Assigned SHG</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('cadre.shg') }}" class="nav-link {{ request()->routeIs('cadre.shg') ? 'active' : '' }}">
            <i class="fas fa-check-square nav-icon" style="color:#fbbf24;"></i>
            <p>Add Attendance</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('cadre.upload.venue.photo') }}"
            class="nav-link {{ request()->routeIs('cadre.upload.venue.photo') ? 'active' : '' }}">
            <i class="nav-icon fas fa-camera" style="color:#fbbf24;"></i>
            <p>Upload Yoga Photo</p>
          </a>
        </li>


      </ul>
    </nav>
  </div>
</aside>