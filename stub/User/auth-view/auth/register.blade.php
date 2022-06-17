@extends('backend.layout-basic')

@section('body-class','register-page')

@section('content')
<div class="register-box">
    <div class="register-logo">
      <a href="../../index2.html"><b>Admin</b>LTE</a>
    </div>
  
    <div class="card">
      <div class="card-body register-card-body">
        <p class="login-box-msg">Register a new membership</p>
  
        <form action="{{url('register')}}" method="post">
          @csrf
          <div class="input-group mt-3">
            <input name="name" type="text" class="form-control {{$errors->has('name') ? 'is-invalid':''}}" value="{{old("name")}}" placeholder="Full name">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
                @if($errors->has('name'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('name')}}
                    </div>
                @endif
            </div>
          </div>
          <div class="input-group mt-3">
            <input type="email" name="email" class="form-control {{$errors->has('email') ? 'is-invalid':''}}" value="{{old("email")}}" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
                @if($errors->has('email'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('email')}}
                    </div>
                @endif
            </div>
          </div>

          <div class="input-group mt-3">
            <input type="password" name="password" class="form-control {{$errors->has('password') ? 'is-invalid':''}}" placeholder="Password">
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
            <input type="password" name="password_confirmation" class="form-control {{$errors->has('password_confirmation') ? 'is-invalid':''}}" placeholder="Retype password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                <label for="agreeTerms">
                 I agree to the <a href="#">terms</a>
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Register</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
  
        <div class="social-auth-links text-center">
          <p>- OR -</p>
          <a href="#" class="btn btn-block btn-primary">
            <i class="fab fa-facebook mr-2"></i>
            Sign up using Facebook
          </a>
          <a href="#" class="btn btn-block btn-danger">
            <i class="fab fa-google-plus mr-2"></i>
            Sign up using Google+
          </a>
        </div>
  
        <a href="{{route('login')}}" class="text-center">I already have a membership</a>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
@endsection