@extends('layouts.app') @section('content')
<div class="container" id="container">

  <div class="col-sm-offset-1 col-sm-10">
    {{-- if there is no session data don't show the form --}}
    @if ((session()->has('verify')))
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4>
          Enter Code the Code You Recieved
        </h4>
      </div>

      <div class="panel-body">

        <form class="navbar-form" method="post" role="search" action="{{ url('/verify-registration') }}">
          {{ csrf_field() }}

          <!-- Enter the Code -->
          @if ($result != '')
          {{-- Show an error if the code is incorrect. --}}
          <p class="alert alert-dismissible alert-danger">
            <strong>{{$result}}</strong>
          </p>
          @endif
          <div class="form-group">

            <label for="group-user-number" class="col-sm-3 control-label">Enter Code:</label>
            <div class="col-sm-6">
              <input type="text" name="code" class="form-control" value="">
              @if ($errors->has('code'))
              <p class="alert alert-dismissible alert-danger">
                <strong>{{ $errors->first('code') }}</strong>
              </p>
              @endif
            </div>
          </div>

          <!-- Submit Code Button -->
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
              <button type="submit" class="btn btn-primary">
                <i class="glyphicon glyphicon-ok" aria-hidden="true"></i>
                Verify
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
    @else
    <h1>Your session has expired.</h1>
    @endif
  </div>
</div>

@endsection
