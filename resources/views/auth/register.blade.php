@extends('layouts.app') @section('content')
<div class="container" id="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h4>Register</h4>
        </div>

        <div class="panel-body">
          <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              <label for="name" class="col-md-4 control-label"> Name</label>

              <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus> @if ($errors->has('name'))
                <p class="alert alert-dismissible alert-danger">
                  <strong>{{ $errors->first('name') }}</strong>
                </p>
                @endif
              </div>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <label for="email" class="col-md-4 control-label">E-Mail Address</label>

              <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required> @if ($errors->has('email'))
                <p class="alert alert-dismissible alert-danger">
                  <strong>{{ $errors->first('email') }}</strong>
                </p>
                @endif
              </div>
            </div>

            <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
              <label for="phone_number" class="col-md-4 control-label">
                Cell Number
              </label>

              <div class="col-md-6">
                <input id="phone_number" type="tel" class="form-control" name="phone_number" value="{{ old('phone_number') }}" required> @if ($errors->has('phone_number'))
                <p class="alert alert-dismissible alert-danger">
                  <strong>{{ $errors->first('phone_number') }}</strong>
                </p>
                @endif
              </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              <label for="password" class="col-md-4 control-label">Password</label>

              <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" required> @if ($errors->has('password'))
                <p class="alert alert-dismissible alert-danger">
                  <strong>{{ $errors->first('password') }}</strong>
                </p>
                @endif
              </div>
            </div>

            <div class="form-group">
              <label for="password-confirm" class="col-md-4 control-label">
                Confirm Password
              </label>

              <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Register
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
