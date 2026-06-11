<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit District User — {{ $user->name }}</title>
  @include('state.includes.header')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  @include('state.includes.navbar')
  @include('state.includes.sidebar')

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit District User</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('state.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('state.users.index') }}">Users</a></li>
              <li class="breadcrumb-item active">Edit</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-md-7">

            <div class="card shadow-sm">
              <div class="card-header" style="background:#155724;color:#fff;">
                <h5 class="mb-0"><i class="fas fa-user-edit mr-2"></i>Edit: {{ $user->name }}</h5>
              </div>
              <div class="card-body">

                @if(session('success'))
                  <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                  </div>
                @endif

                @if($errors->any())
                  <div class="alert alert-danger">
                    <ul class="mb-0">
                      @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif

                <form method="POST" action="{{ route('state.users.update', $user->id) }}">
                  @csrf

                  <div class="form-group">
                    <label>Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $user->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>

                  <div class="form-group">
                    <label>Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $user->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>

                  <div class="form-group">
                    <label>District <span class="text-danger">*</span></label>
                    <select name="district_id" class="form-control @error('district_id') is-invalid @enderror" required>
                      <option value="">— Select District —</option>
                      @foreach($districts as $district)
                        <option value="{{ $district->district_id }}"
                          {{ old('district_id', $user->district) == $district->district_id ? 'selected' : '' }}>
                          {{ $district->district_name }}
                        </option>
                      @endforeach
                    </select>
                    @error('district_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>

                  <div class="d-flex justify-content-between">
                    <a href="{{ route('state.users.index') }}" class="btn btn-secondary">
                      <i class="fas fa-arrow-left mr-1"></i> Back
                    </a>
                    <button type="submit" class="btn btn-success">
                      <i class="fas fa-save mr-1"></i> Save Changes
                    </button>
                  </div>
                </form>

              </div>
            </div>

            {{-- PASSWORD RESET CARD --}}
            <div class="card shadow-sm mt-3">
              <div class="card-header bg-warning">
                <h6 class="mb-0"><i class="fas fa-key mr-2"></i>Password Management</h6>
              </div>
              <div class="card-body">
                <p class="mb-3 text-muted" style="font-size:0.9rem;">
                  Current status:
                  @if($user->password)
                    <span class="badge badge-success">Password Set</span>
                  @else
                    <span class="badge badge-warning">No Password — user will be prompted on next login</span>
                  @endif
                </p>
                <form method="POST" action="{{ route('state.users.reset-password', $user->id) }}"
                      onsubmit="return confirm('Reset password for {{ addslashes($user->name) }}? They will need to set a new password on next login.')">
                  @csrf
                  <button type="submit" class="btn btn-warning btn-sm">
                    <i class="fas fa-redo mr-1"></i> Reset Password to Null
                  </button>
                </form>
              </div>
            </div>

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
