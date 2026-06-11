<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add District User</title>
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
            <h1 class="m-0">Add District User</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('state.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('state.users.index') }}">Users</a></li>
              <li class="breadcrumb-item active">Add</li>
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
                <h5 class="mb-0"><i class="fas fa-user-plus mr-2"></i>New District User</h5>
              </div>
              <div class="card-body">

                @if($errors->any())
                  <div class="alert alert-danger">
                    <ul class="mb-0">
                      @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif

                <form method="POST" action="{{ route('state.users.store') }}">
                  @csrf

                  <div class="form-group">
                    <label>Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" placeholder="Full name" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>

                  <div class="form-group">
                    <label>Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" placeholder="user@example.com" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>

                  <div class="form-group">
                    <label>District <span class="text-danger">*</span></label>
                    <select name="district_id" class="form-control @error('district_id') is-invalid @enderror" required>
                      <option value="">— Select District —</option>
                      @foreach($districts as $district)
                        <option value="{{ $district->district_id }}"
                          {{ old('district_id') == $district->district_id ? 'selected' : '' }}>
                          {{ $district->district_name }}
                        </option>
                      @endforeach
                    </select>
                    @error('district_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>

                  <div class="alert alert-info py-2 px-3" style="font-size:0.85rem;">
                    <i class="fas fa-info-circle mr-1"></i>
                    Password is not set. The user will be prompted to create one on first login.
                  </div>

                  <div class="d-flex justify-content-between">
                    <a href="{{ route('state.users.index') }}" class="btn btn-secondary">
                      <i class="fas fa-arrow-left mr-1"></i> Back
                    </a>
                    <button type="submit" class="btn btn-success">
                      <i class="fas fa-save mr-1"></i> Create User
                    </button>
                  </div>
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
