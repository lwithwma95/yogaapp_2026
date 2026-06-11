<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-success elevation-4" style="background: linear-gradient(180deg, #1a3c2e 0%, #14532d 100%);">
  <a href="{{ route('state.dashboard') }}" class="brand-link"
    style="border-bottom: 1px solid rgba(255,255,255,0.1); padding: 10px 14px; background: transparent;">
    <img src="{{ asset('assets/images/assam_govt.svg') }}" alt="Assam Govt Logo"
      class="brand-image img-circle elevation-3"
      style="width: 33px; height: 33px; background: #ffffff; border-radius: 50%; padding: 2px; opacity: 1;">
    <strong>IYD Assam</strong>
  </a>

  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="border-bottom: 1px solid rgba(255,255,255,0.08);">
      <div class="image">
        <img src="{{ asset('assets/images/asrlm_logo.png') }}" class="img-circle elevation-2" alt="User">
      </div>
      <div class="info">
        <a href="#" class="d-block" style="color: #f0fdf4; font-size: 0.88rem;">{{ auth()->user()->name }}</a>
        <span style="font-size: 0.72rem; color: #86efac;">State Admin</span>
      </div>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item">
          <a href="{{ route('state.dashboard') }}"
            class="nav-link {{ request()->routeIs('state.dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-home" style="color: #fbbf24;"></i>
            <p>Dashboard</p>
          </a>
        </li>
         <li class="nav-item">
          <a href="{{ route('state.registrations') }}"
            class="nav-link {{ request()->routeIs('state.registrations') ? 'active' : '' }}">
            <i class="nav-icon fas fa-address-book" style="color: #fbbf24;"></i>
            <p>Registrations</p>
          </a>
        </li>

        

        <!-- <li class="nav-item has-treeview
          {{ request()->routeIs('state.district.*', 'state.block.*', 'state.gp.*', 'state.village.*', 'state.shg.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link
            {{ request()->routeIs('state.district.*', 'state.block.*', 'state.gp.*', 'state.village.*', 'state.shg.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-leaf" style="color: #fbbf24;"></i>
            <p>
              Registrations
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('state.dashboard') }}"
                class="nav-link {{ request()->routeIs('state.dashboard') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon" style="color: #86efac;"></i>
                <p>District-wise</p>
              </a>
            </li>
          </ul>
        </li> -->

        <li class="nav-item">
          <a href="{{ route('state.cadrevenuemapping') }}"
            class="nav-link {{ request()->routeIs('state.cadrevenuemapping') ? 'active' : '' }}">
            <i class="nav-icon fas fa-map-marker-alt" style="color: #fbbf24;"></i>
            <p>Venue</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('state.users.index') }}"
            class="nav-link {{ request()->routeIs('state.users.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users" style="color: #fbbf24;"></i>
            <p>Users</p>
          </a>
        </li>

      </ul>
    </nav>
  </div>
</aside>
