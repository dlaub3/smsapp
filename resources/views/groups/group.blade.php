@extends('layouts.app')
@section('content')
<div class="container" id="container">
  <div class="col-sm-offset-1 col-sm-10">

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h1>Dashboard</h1>
      </div>
      <div class="panel-body">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h2>Let's get started!</h2>
          </div>
          <div class="panel-body">
            <a href="/my-groups/new">
              <h4 type="submit" class="btn btn-primary">
                <i class="glyphicon glyphicon-plus"></i> Create A New Group
              </h4>
            </a>
            <a href="/affiliations" class="pull-right">
              <h4 type="submit" class="btn btn-primary">
              <i class="glyphicon glyphicon-link"></i>
                Group Affiliations
              </h4>
            </a>
          </div>
        </div>
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h2>  Manage your groups </h2>
          </div>
          <div class="panel-body">
            @if (count($groups) > 0)
            @foreach ($groups as $group)
            <a href="{{url('/my-groups/view/' . $group->slug)}}">
              <div class="btn btn-primary btn-block">
                <i class="glyphicon glyphicon-user" aria-hidden="true"></i>
                <i class="glyphicon glyphicon-user" aria-hidden="true"></i>
                <i class="glyphicon glyphicon-user" aria-hidden="true"></i>
                <h3>
                  {{$group->name}}
                </h3>
              </div>
            </a>
            @endforeach
            @else
            <h4>You haven't created any groups.</h4>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
