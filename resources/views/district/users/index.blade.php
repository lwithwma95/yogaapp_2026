<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Block Users</title>
  @include('district.includes.header')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  @include('district.includes.navbar')
  @include('district.includes.sidebar')

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Block Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('district.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">

        {{-- BANNER --}}
        <div class="card mb-3" style="border:none;border-radius:12px;background:linear-gradient(135deg,#155724,#1a6b2e,#28a745);color:#fff;">
          <div class="card-body py-3 px-4">
            <div class="d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center">
                <i class="fas fa-users fa-2x mr-3" style="opacity:.85"></i>
                <div>
                  <div style="font-size:11px;opacity:.75;text-transform:uppercase;letter-spacing:.6px;">Management</div>
                  <div style="font-size:1.4rem;font-weight:800;">Block Users</div>
                </div>
              </div>
              <a href="{{ route('district.users.create') }}" class="btn btn-light btn-sm font-weight-bold">
                <i class="fas fa-plus mr-1"></i> Add User
              </a>
            </div>
          </div>
        </div>

        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
          </div>
        @endif

        {{-- USERS TABLE --}}
        <div class="card shadow-sm">
          <div class="card-body p-0">
            <table class="table table-hover table-bordered mb-0">
              <thead style="background:#155724;color:#fff;">
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Block</th>
                  <th>Password</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($users as $i => $user)
                  <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ optional($user->blockData)->block_name ?? '—' }}</td>
                    <td>
                      @if($user->password)
                        <span class="badge badge-success">Set</span>
                      @else
                        <span class="badge badge-warning">Not Set</span>
                      @endif
                    </td>
                    <td class="text-center">
                      <a href="{{ route('district.users.edit', $user->id) }}"
                         class="btn btn-sm btn-primary mr-1">
                        <i class="fas fa-edit"></i> Edit
                      </a>
                      <form method="POST" action="{{ route('district.users.reset-password', $user->id) }}"
                            class="d-inline"
                            onsubmit="return confirm('Reset this user\'s password?')">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-warning">
                          <i class="fas fa-key"></i> Reset Password
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center text-muted py-4">No block users found.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </section>
  </div>

  <footer class="main-footer text-sm">
    <strong>IYD Assam</strong> &copy; {{ date('Y') }}
  </footer>
</div>
</body>
</html>
