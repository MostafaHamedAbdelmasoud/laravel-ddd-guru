@extends('backend.layout-basic')

@section('body-class','login-page')

@section('content')

<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
      <form action="{{route('password.email')}}" method="post">
        @csrf
        <div class="input-group">
          <input type="email" name="email" class="form-control {{$errors->has('email') ? 'is-invalid':''}}" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        @if($errors->has('email'))
          <div class="row">
            <div class="col-md-12">
              <div class="alert alert-danger w-100 m-0" role="alert">
                  {{$errors->first('email')}}
              </div>
            </div>
          </div>
        @endif
        @if(session()->has('status'))
          <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success w-100 m-0" role="alert">
                    {{session()->get('status')}}
                </div>
            </div>
          </div>
        @endif

        <div class="row mt-3">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Request new password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="{{route('login')}}">Login</a>
      </p>
      <p class="mb-0">
        <a href="{{route('register')}}" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
@endsection
