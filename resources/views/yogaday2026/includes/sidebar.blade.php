<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('block.dashboard') }}" class="brand-link">
    <img src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
      class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Block Admin</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Alexander Pierce</a>
      </div>
    </div>



    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

        <li class="nav-header">VERTICLES</li>
        <!-- SMIBCB -->
        <li class="nav-item has-treeview">

          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-university text-warning"></i>
            <p>
              SMIBCB
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <!-- SHG -->
            <li class="nav-item has-treeview">

              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-users text-primary"></i>
                <p>
                  SHG
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>

              <ul class="nav nav-treeview">

                <li class="nav-item">
                  <a href="{{ route('shg.show') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-info"></i>
                    <p>All SHG</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('block.shgmembers.search') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-info"></i>
                    <p>All SHG Members</p>
                  </a>
                </li>

              </ul>

            </li>

            <!-- VO -->
            <li class="nav-item has-treeview">

              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-leaf text-primary"></i>
                <p>
                  VO
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>

              <ul class="nav nav-treeview">

                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon text-info"></i>
                    <p>VO Loans</p>
                  </a>
                </li>

              </ul>

            </li>

            <!-- CLF -->
            <li class="nav-item has-treeview">

              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cloud text-primary"></i>
                <p>
                  CLF
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>

              <ul class="nav nav-treeview">

                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon text-info"></i>
                    <p>CLF Loans</p>
                  </a>
                </li>

              </ul>

            </li>

          </ul>

        </li>
        <!-- FI -->
        <li class="nav-item has-treeview">

          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-hand-holding-usd text-warning"></i>
            <p>
              FI
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>

          <ul class="nav nav-treeview">

            <!-- SHG -->
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-users text-primary"></i>
                <p>
                  SHG
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>

              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('shgloan.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-info"></i>
                    <p>SHG Loans</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('shgloan.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon text-info"></i>
                    <p>SHG Member Loans</p>
                  </a>
                </li>

              </ul>

            </li>

            <!-- VO -->
            <li class="nav-item has-treeview">

              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-leaf text-primary"></i>
                <p>
                  VO
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>

              <ul class="nav nav-treeview">

                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon text-info"></i>
                    <p>VO Loans</p>
                  </a>
                </li>

              </ul>

            </li>

            <!-- CLF -->
            <li class="nav-item has-treeview">

              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cloud text-primary"></i>
                <p>
                  CLF
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>

              <ul class="nav nav-treeview">

                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon text-info"></i>
                    <p>CLF Loans</p>
                  </a>
                </li>

              </ul>

            </li>

          </ul>

        </li>

        <li class="nav-header">Block Admin</li>

        <li class="nav-item has-treeview">

          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user  text-warning"></i>
            <p>
              Block Admins
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>

          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="{{ route('blockadmin.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon text-info"></i>
                <p>Block Admin</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('block.cadres') }}" class="nav-link">
                <i class="far fa-circle nav-icon text-info"></i>
                <p>Cadres</p>
              </a>
            </li>

          </ul>

        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>