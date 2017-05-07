@extends('layouts.app')
@section('content')
<div class="container" id="container">
  <div class="col-sm-offset-1 col-sm-10">

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4>
          Join: {{ $group->name }}
        </h4>
      </div>

      <div class="panel-body">

        <!-- New Group Form -->
        <form action="{{ url('join/sendcode/' . $group->id ) }}" method="POST" class="form-horizontal">
          {{ csrf_field() }}

          <!-- User Name -->
          <div class="form-group">
            <label for="group-user-name {{ $errors->has('name') ? ' has-error' : '' }}" class="col-sm-3 control-label">Name</label>
            <div class="col-sm-6">
              <input type="text" name="name" class="form-control" value="{{ old('name') }}">
              @if ($errors->has('name'))
              <p class="alert alert-dismissible alert-danger">
                <strong>{{ $errors->first('name') }}</strong>
              </p>
              @endif
            </div>
          </div>

          <!-- Add User Cell Number -->
          <div class="form-group">
            <label for="group-user-number {{ $errors->has('phone_number') ? ' has-error' : '' }}" class="col-sm-3 control-label">
              Cell Number
            </label>

            <div class="col-sm-6">
              <input type="tel" name="phone_number" class="form-control" value="{{ old('phone_number') }}">
              @if ($errors->has('phone_number'))
              <p class="alert alert-dismissible alert-danger">
                <strong>{{ $errors->first('phone_number') }}</strong>
              </p>
              @endif
            </div>
          </div>

          <!-- Join Button -->
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
              <button type="submit" class="btn btn-primary">
                <i class="glyphicon glyphicon-plus" aria-hidden="true"></i>
                Join
            </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
