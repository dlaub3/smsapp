@extends('layouts.app')
@section('content')
<div class="container" id="container">
  <div class="col-sm-offset-1 col-sm-10">

   @if ($groupsUser)
    <div class="panel panel-primary">
      <div class="panel-heading" style="min-height: 0px;">
        <h3 class="panel-title">
          <i class="glyphicon glyphicon-user" aria-hidden="true"></i>  Update {{$groupsUser->name}}'s Info
        </h3>
      </div>

      <!-- Add the Body -->
      <div class="panel-body">

        <!-- Update User Info Form -->
        <form action="{{ url('my-groups/user/edit/' . $groupsUser->id ) }}" method="POST" class="form-horizontal" name="update-user">
          {{ csrf_field() }}

          <!-- User Name -->
          <div class="form-group">
            <label for="group-user-name" class="col-sm-3 control-label">
              User Name
            </label>
            <div class="col-sm-6">
              <input type="text" name="name" class="form-control" value="{{$groupsUser->name}}">
              @if ($errors->has('name'))
                <p class="alert alert-dismissible alert-danger">
                  <strong>{{ $errors->first('name') }}</strong>
                </p>
              @endif
            </div>
          </div>

          <!-- Add User Cell Number -->
          <div class="form-group">
            <label for="group-user-number" class="col-sm-3 control-label">Cell Number</label>
            <div class="col-sm-6">
              <input type="tel" name="phone_number" class="form-control" value="{{ $groupsUser->phone_number }}"> @if ($errors->has('phone_number'))
              <p class="alert alert-dismissible alert-danger">
                <strong>{{ $errors->first('phone_number') }}</strong>
              </p>
              @endif
            </div>
          </div>

          <!-- Update User Button -->
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
              <button type="submit" class="btn btn-primary">
                <i class="glyphicon glyphicon-save" aria-hidden="true"></i>
                  Update
              </button>
            </div>
          </div>
        </form>
        <form action="{{ url('my-groups/user/delete/' . $groupsUser->id) }}" method="POST" class="pull-right">
          {{ csrf_field() }} {{ method_field('DELETE') }}

          <button type="submit" class="btn btn-danger btn-raised">
            <i class="glyphicon glyphicon-trash" aria-hidden="true"></i>Delete
          </button>
        </form>


      </div>
        <div class="panel-footer">
          <a href="{{ url($backUrl) }}">
            <button type="submit" class="btn btn-primary">
          <i class="glyphicon glyphicon-arrow-left" aria-hidden="true"></i>
              Back
            </button>
          </a>
        </div>
    </div>
  </div>
</div>
@endif
@endsection
