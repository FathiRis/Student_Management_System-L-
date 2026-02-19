<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>
<body>
  <div class="card login-card">
    <div class="row g-0">
      <div class="col-md-5 login-image"></div>
      <div class="col-md-7">
        <div class="card-body p-4 p-lg-5">
          <h3 class="mb-2">Student Management System</h3>
          <p class="text-muted mb-4">Sign in as admin, teacher, or student.</p>

          @if ($errors->any())
            <div class="alert alert-danger py-2">
              {{ $errors->first() }}
            </div>
          @endif

          <form method="POST" action="{{ route('login.attempt') }}">
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus class="form-control form-control-lg">
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="password" id="password" required class="form-control form-control-lg">
            </div>

            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
              <label class="form-check-label" for="remember">Remember me</label>
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-100">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
