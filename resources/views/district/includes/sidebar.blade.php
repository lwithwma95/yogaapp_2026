<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-success elevation-4" style="background: linear-gradient(180deg, #1a3c2e 0%, #14532d 100%);">
  <!-- Brand Logo -->
  <a href="{{ route('district.dashboard') }}" class="brand-link"
    style="border-bottom: 1px solid rgba(255,255,255,0.1); padding: 10px 14px; background: transparent;">
    <img src="{{ asset('assets/images/assam_govt.svg') }}" alt="Assam Govt Logo"
      class="brand-image img-circle elevation-3"
      style="width: 33px; height: 33px; background: #ffffff; border-radius: 50%; padding: 2px; opacity: 1;">
    <strong>IYD Assam</strong>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="border-bottom: 1px solid rgba(255,255,255,0.08);">
      <div class="image">
        <img src="{{ asset('assets/images/asrlm_logo.png') }}" class="img-circle elevation-2" alt="User">
      </div>
      <div class="info">
        <a href="#" class="d-block" style="color: #f0fdf4; font-size: 0.88rem;">{{ auth()->user()->name }}</a>
        <span style="font-size: 0.72rem; color: #86efac;">District Admin</span>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <!-- Dashboard -->
        <li class="nav-item">
          <a href="{{ route('district.dashboard') }}"
            class="nav-link {{ request()->routeIs('district.dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-home" style="color: #fbbf24;"></i>
            <p>Dashboard</p>
          </a>
        </li>

        

        <!-- Registrations -->
         <li class="nav-item">
          <a href="{{ route('district.registrations') }}"
            class="nav-link @php if(!empty($active_page) && $active_page === 'registrations') { echo 'active'; } @endphp">
            <i class="nav-icon fas fa-address-book" style="color: #fbbf24;"></i>
            <p>Registration</p>
          </a>
        </li>
        
        <!-- Cadre Venue Mapping -->
        <li class="nav-item">
          <a href="{{ route('district.cadrevenuemapping') }}"
            class="nav-link {{ request()->routeIs('district.cadrevenuemapping') ? 'active' : '' }}">
            <i class="nav-icon fas fa-map-marker-alt" style="color: #fbbf24;"></i>
            <p>Venue</p>
          </a>
        </li>

        <!-- Users -->
        <li class="nav-item">
          <a href="{{ route('district.users.index') }}"
            class="nav-link {{ request()->routeIs('district.users.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users" style="color: #fbbf24;"></i>
            <p>Users</p>
          </a>
        </li>

      </ul>
    </nav>
  </div>
</aside>
