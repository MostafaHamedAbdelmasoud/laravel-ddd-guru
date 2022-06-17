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
      <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>

      <form action="{{route('password.update')}}" method="post">
        @csrf
        <input type="hidden" name="token" value="{{Arr::last(request()->segments())}}">
        <input type="hidden" name="email" value="{{Request::get('email')}}">
        <div class="input-group ">
          <input type="password" name="password" class="form-control {{$errors->has("password")?'is-invalid':''}}" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
              @if($errors->has('password'))
                  <div class="alert alert-danger w-100 m-0" role="alert">
                      {{$errors->first('password')}}
                  </div>
              @endif
          </div>
        </div>
        <div class="input-group mt-3">
          <input type="password" name="password_confirmation" class="form-control {{$errors->has("password")?'is-invalid':''}}" placeholder="Confirm Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Change password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <p class="mt-3 mb-1">
        <a href="{{route('login')}}">Login</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
@endsection
