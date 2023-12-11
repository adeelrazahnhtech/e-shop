<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel Shop :: User Panel</title>
    <!-- Google Font: Source Sans Pro -->
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> --}}
    <!-- Font Awesome -->
    {{-- <link rel="stylesheet" href="{{ asset('admin-assets/plugins/fontawesome-free/css/all.min.css') }}"> --}}

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin-assets/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom.css')}}">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        @include('message')
        <div class="card card-outline card-primary">
              <div class="card-header text-center">
                <a href="#" class="h3">User Panel</a>
              </div>
              <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <form action="{{ route('user.process') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" value="{{ old('first_name')}}" name="first_name" id="first_name" class="form-control" placeholder="first_name">
                        <div class="input-group-append">
                              <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                              </div>
                        </div>
                      </div>
                      @if ($errors->has('first_name'))
                      <p class="alert alert-danger">{{ $errors->first('first_name') }}</p>
                      @endif
                      <div class="input-group mb-3">
                        <input type="text" value="{{ old('last_name')}}" name="last_name" id="last_name" class="form-control" placeholder="last_name">
                        <div class="input-group-append">
                              <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                              </div>
                        </div>
                      </div>
                      @if ($errors->has('last_name'))
                      <p class="alert alert-danger">{{ $errors->first('last_name') }}</p>
                      @endif
                      <div class="input-group mb-3">
                        <input type="email" value="{{ old('email')}}" name="email" id="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                              <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                              </div>
                        </div>
                      </div>
                      @if ($errors->has('email'))
                      <p class="alert alert-danger">{{ $errors->first('email') }}</p>
                      @endif
                      <div class="input-group mb-3">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                              <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                              </div>
                        </div>
                      </div>
                      @if ($errors->has('password'))
                      <p class="alert alert-danger">{{ $errors->first('password') }}</p>
                      @endif
                      <div class="input-group mb-3">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Password Confirmation">
                        <div class="input-group-append">
                              <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                              </div>
                        </div>
                      </div>
                      @if ($errors->has('password_confirmation'))
                      <p class="alert alert-danger">{{ $errors->first('password_confirmation') }}</p>
                      @endif
                      <div class="input-group mb-3">
                        <select name="role" id="role" class="form-control">
                          <option selected disabled>Select A Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">
                                    {{ $role->role_type }}
                                </option>
                            @endforeach
                        </select>
                       
                      </div>
                      @if ($errors->has('role'))
                      <p class="alert alert-danger">{{ $errors->first('role') }}</p>
                      @endif
                      <div class="row">
                        <div class="col-4">
                              <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                      </div>
                </form>
                  <p class="mb-1 mt-3">
                      <a href="forgot-password.html">I forgot my password</a>
                </p>					
              </div>
              <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    <!-- ./wrapper -->
		<!-- jQuery -->
		<script src="{{ asset('admin-assets/plugins/jquery/jquery.min.js')}}"></script>
		<!-- Bootstrap 4 -->
		<script src="{{ asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
		<!-- AdminLTE App -->
		<script src="{{ asset('admin-assets/js/adminlte.min.js')}}"></script>
		<!-- AdminLTE for demo purposes -->
		<!-- <script src="js/demo.js"></script> -->
    
</body>
</html>