<nav class="main-header navbar navbar-expand navbar-dark"
  style="background:#14532d;border-bottom:1px solid rgba(255,255,255,0.1);min-height:52px;">

  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars"></i>
      </a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{ route('cadre.dashboard') }}" class="nav-link" style="color:#d1fae5;">
        <i class="fas fa-home mr-1"></i> Home
      </a>
    </li>
  </ul>

  <span class="d-none d-md-inline"
    style="position:absolute;left:50%;transform:translateX(-50%);color:#86efac;font-size:0.8rem;font-weight:500;letter-spacing:0.4px;white-space:nowrap;">
    International Yoga Day Portal &mdash; Assam
  </span>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <form method="POST" action="{{ route('logout') }}" class="m-0">
        @csrf
        <button type="submit" class="nav-link btn btn-link"
          style="color:#fca5a5;cursor:pointer;border:none;background:none;padding:.4rem .75rem;font-size:0.875rem;">
          <i class="fas fa-sign-out-alt mr-1"></i> Logout
        </button>
      </form>
    </li>
  </ul>

</nav>
