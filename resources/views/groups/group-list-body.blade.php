@extends('layouts.app')
@section('content')
<div class="container" id="container">
  <div class="col-sm-offset-1 col-sm-10">
    @foreach ($groups as $group)
    <div class="panel panel-primary" style="margin-bottom: 5px;">
      <div class="panel-heading">
        <h3>  {{$group->name}} </h3>
      </div>
        <div class="panel-body">
          <div class="panel-group" id="messageupdate">
            <!-- Group Users List -->
            @include('groups.send-message')

            <!-- Group Users List -->
            @include('groups.add-user')
          </div>
          <!-- Group Users List -->
          @include('groups.group-users-list')

        </div>
        <div class="panel-footer">
          <a href="{{ url('dashboard') }}">
            <button type="submit" class="btn btn-primary">
          <i class="glyphicon glyphicon-arrow-left" aria-hidden="true"></i>
              Dashboard
            </button>
          </a>

          <form action="{{ url('my-groups/delete/' . $group->slug) }}" method="POST" class="pull-right">
            {{ csrf_field() }} {{ method_field('DELETE') }}

            <button type="submit" class="btn btn-danger btn-raised">
              <i class="glyphicon glyphicon-trash" aria-hidden="true"></i>Delete
            </button>
          </form>
        </div>
    </div>
    @endforeach
  </div>
</div>
@endsection
