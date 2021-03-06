@extends('layouts.app')
@section('content')
<div class="container" id="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-primary">
        <div class="panel-heading">Create Group</div>
        <div class="panel-body">
          <form class="form-horizontal" role="form" method="POST" action="{{ url('my-groups/new') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              <label for="name" class="col-md-4 control-label">Group Name</label>

              <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                @if ($errors->has('name'))
                <p class="alert alert-dismissible alert-danger">
                  <strong>{{ $errors->first('name') }}</strong>
                </p>
                @endif
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary btn-raised">
                    <i class="glyphicon glyphicon-plus" aria-hidden="true"></i>
                            Create
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
